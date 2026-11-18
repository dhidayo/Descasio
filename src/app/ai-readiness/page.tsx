import type { Metadata } from "next";
import { PageHero } from "@/components/ui/PageHero";
import { Assessment } from "@/components/forms/Assessment";

export const metadata: Metadata = {
  title: "AI Readiness Assessment",
  description: "Answer 12 questions across 4 dimensions. Get your score and a personalised breakdown in under 5 minutes.",
};

export default function AIReadiness() {
  return (
    <>
      <PageHero
        label="Free assessment"
        title={
          <>
            How ready is your organisation for <span className="text-accent-strong dark:text-accent">AI?</span>
          </>
        }
        intro="Answer 12 questions across 4 dimensions. Get your score and a personalised breakdown in under 5 minutes."
      />
      <section className="mx-auto max-w-3xl px-4 pb-8">
        <div className="glass rounded-[28px] p-6 md:p-10">
          <Assessment />
        </div>
      </section>
    </>
  );
}
