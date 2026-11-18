"use server";

import { z } from "zod";
import { supabaseAdmin } from "./supabase";
import { questions, score } from "@/content/assessment";

export type FormState = { ok: boolean; message: string; errors?: Record<string, string> } | null;

const topics = ["general", "dip", "cloud", "ai-advisory", "plugiq", "partnership"] as const;

const contactSchema = z.object({
  first_name: z.string().trim().min(1, "Enter your first name").max(100),
  last_name: z.string().trim().min(1, "Enter your last name").max(100),
  email: z.string().trim().email("Enter a valid work email").max(254),
  company: z.string().trim().min(1, "Enter your company").max(200),
  topic: z.enum(topics, { message: "Choose a topic" }),
  message: z.string().trim().min(10, "Tell us a little more (at least 10 characters)").max(5000),
});

const notConnected =
  "Our form is not connected yet. Please email hi@descasio.io and we'll reply within 4 business hours.";

function fieldErrors(error: z.ZodError) {
  const out: Record<string, string> = {};
  for (const issue of error.issues) {
    const key = String(issue.path[0]);
    if (!out[key]) out[key] = issue.message;
  }
  return out;
}

export async function submitContact(_prev: FormState, data: FormData): Promise<FormState> {
  // Honeypot: real visitors never fill this hidden field.
  if (data.get("website")) return { ok: true, message: "Thanks. We'll be in touch shortly." };

  const parsed = contactSchema.safeParse(Object.fromEntries(data));
  if (!parsed.success) return { ok: false, message: "Please check the highlighted fields.", errors: fieldErrors(parsed.error) };

  const db = supabaseAdmin();
  if (!db) return { ok: false, message: notConnected };

  const { error } = await db.from("contact_requests").insert({ ...parsed.data, source_path: "/contact" });
  if (error) {
    console.error("contact insert failed", error.message);
    return { ok: false, message: "Something went wrong sending your request. Please try again, or email hi@descasio.io." };
  }
  return { ok: true, message: "Thanks. Your request is with our team, and we'll reply within 4 business hours." };
}

const readinessSchema = z.object({
  first_name: z.string().trim().min(1, "Enter your first name").max(100),
  last_name: z.string().trim().min(1, "Enter your last name").max(100),
  email: z.string().trim().email("Enter a valid work email").max(254),
  company: z.string().trim().min(1, "Enter your company").max(200),
  job_title: z.string().trim().max(150).optional(),
  company_size: z.enum(["1-50", "51-200", "201-1000", "1000+"]).optional().or(z.literal("")),
  answers: z
    .string()
    .transform((s) => s.split(",").map(Number))
    .pipe(z.array(z.number().int().min(0).max(3)).length(questions.length)),
});

/** Saves the lead and returns OK so the visitor can see their results. Results are shown even if saving fails. */
export async function saveReadiness(_prev: FormState, data: FormData): Promise<FormState> {
  if (data.get("website")) return { ok: true, message: "" };
  const parsed = readinessSchema.safeParse(Object.fromEntries(data));
  if (!parsed.success) return { ok: false, message: "Please check the highlighted fields.", errors: fieldErrors(parsed.error) };

  const { answers, company_size, ...lead } = parsed.data;
  const result = score(answers);
  const db = supabaseAdmin();
  if (db) {
    const { error } = await db.from("readiness_results").insert({
      ...lead,
      company_size: company_size || null,
      answers,
      total_score: result.total,
      dim_scores: result.dims,
    });
    if (error) console.error("readiness insert failed", error.message);
  }
  return { ok: true, message: "" };
}
