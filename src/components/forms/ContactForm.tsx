"use client";

import { useActionState } from "react";
import { CheckCircle, WarningCircle } from "@phosphor-icons/react";
import { submitContact, type FormState } from "@/lib/actions";
import { Honeypot, Input, Select, SubmitButton, Textarea } from "./Field";

const topicOptions = [
  ["general", "General Inquiry"],
  ["cloud", "Cloud Services"],
  ["ai-advisory", "AI Advisory"],
  ["plugiq", "PlugIQ Demo"],
  ["partnership", "Partnership"],
] as const;

export function ContactForm({ defaultTopic }: { defaultTopic?: string }) {
  const [state, action, pending] = useActionState<FormState, FormData>(submitContact, null);

  if (state?.ok) {
    return (
      <div role="status" className="flex flex-col items-start gap-4 py-10">
        <CheckCircle size={44} weight="duotone" className="text-accent" />
        <h2 className="text-2xl font-extrabold text-fg">Request received</h2>
        <p className="max-w-md leading-relaxed text-muted">{state.message}</p>
      </div>
    );
  }

  const e = state?.errors ?? {};
  return (
    <form action={action} noValidate className="relative grid gap-5 sm:grid-cols-2">
      <Honeypot />
      <Input name="first_name" label="First name" required autoComplete="given-name" error={e.first_name} />
      <Input name="last_name" label="Last name" required autoComplete="family-name" error={e.last_name} />
      <Input name="email" type="email" label="Work email" required autoComplete="email" error={e.email} />
      <Input name="company" label="Company" required autoComplete="organization" error={e.company} />
      <div className="sm:col-span-2">
        <Select name="topic" label="Topic" required defaultValue={topicOptions.some(([v]) => v === defaultTopic) ? defaultTopic : ""} error={e.topic}>
          <option value="" disabled>
            Select a topic
          </option>
          {topicOptions.map(([v, l]) => (
            <option key={v} value={v}>
              {l}
            </option>
          ))}
        </Select>
      </div>
      <div className="sm:col-span-2">
        <Textarea name="message" label="Message" required error={e.message} />
      </div>
      {state && !state.ok && (
        <p role="alert" className="flex items-start gap-2 rounded-[14px] bg-accent-soft px-4 py-3 text-[15px] font-medium text-fg sm:col-span-2">
          <WarningCircle size={20} weight="fill" className="mt-0.5 shrink-0 text-accent-strong dark:text-accent" />
          {state.message}
        </p>
      )}
      <div className="sm:col-span-2">
        <SubmitButton pending={pending}>{pending ? "Sending..." : "Submit Request"}</SubmitButton>
      </div>
    </form>
  );
}
