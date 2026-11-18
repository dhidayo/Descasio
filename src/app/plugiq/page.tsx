import type { Metadata } from "next";
import { ArrowRight, Target, MagicWand, PlugsConnected, ChartLineUp } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { SpotlightCard } from "@/components/ui/SpotlightCard";
import { CtaBand } from "@/components/ui/CtaBand";

export const metadata: Metadata = {
  title: "PlugIQ: The AI Layer for Approval Workflows",
  description:
    "PlugIQ automates enterprise approvals, requisitions, and compliance workflows. Describe your process in plain language. PlugIQ builds it, runs it, audits every action.",
};

const demo = "/contact?topic=plugiq";

const steps = [
  { icon: Target, title: "Define your goal", body: "“I want purchase approvals completed within 24 hours with full audit trail.”" },
  { icon: MagicWand, title: "PlugIQ builds the workflow", body: "AI designs the routing, approver logic, escalation rules, and notifications automatically." },
  { icon: PlugsConnected, title: "Connect your systems", body: "Plug into your ERP, HRMS, CRM, or collaboration tools. No custom development required." },
  { icon: ChartLineUp, title: "Monitor and optimise", body: "Real-time dashboards show bottlenecks, approval times, and compliance status." },
];

const useCases = [
  { area: "Procurement", before: "14 days", after: "Same day", title: "Purchase Order Approvals", body: "Multi-level approval routing based on amount thresholds. Auto-escalation on delays. Full audit trail for compliance." },
  { area: "HR Operations", before: "5 days", after: "4 hours", title: "Leave & Expense Approvals", body: "Employee submits via mobile or web. PlugIQ routes to the right manager based on department and policy rules." },
  { area: "Vendor Management", before: "3 weeks", after: "3 days", title: "Vendor Onboarding & KYC", body: "Automated document collection, verification checklists, compliance checks, and approval routing." },
  { area: "Finance", before: "Manual", after: "Real-time", title: "Payment Requisitions", body: "Every payment request captured, routed, approved, and logged automatically. Complete audit trail." },
];

export default function PlugIQ() {
  return (
    <>
      <PageHero
        label="A Descasio product"
        title={
          <>
            The AI layer for <span className="text-accent-strong dark:text-accent">approval workflows</span>
          </>
        }
        intro="PlugIQ automates enterprise approvals, requisitions, and compliance workflows. Describe your process in plain language. PlugIQ builds it, runs it, audits every action."
      >
        <Button href={demo}>Request a Demo</Button>
      </PageHero>

      <section className="mx-auto max-w-6xl px-4 py-12">
        <ol className="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
          {steps.map((s, i) => {
            const Icon = s.icon;
            return (
              <Reveal key={s.title} delay={i * 0.07}>
                <li className="glass relative h-full list-none rounded-[var(--radius-card)] p-7">
                  <span className="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">
                    <Icon size={24} weight="duotone" />
                  </span>
                  <h2 className="mt-6 text-lg font-bold text-fg">{s.title}</h2>
                  <p className="mt-2 leading-relaxed text-muted">{s.body}</p>
                  {i < steps.length - 1 && (
                    <ArrowRight aria-hidden size={18} weight="bold" className="absolute -right-4 top-12 z-10 hidden text-accent lg:block" />
                  )}
                </li>
              </Reveal>
            );
          })}
        </ol>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-20">
        <Reveal>
          <SectionHeading title="Workflows that used to take weeks." body="Real enterprise processes automated with PlugIQ. Live in days, not months." />
        </Reveal>
        <div className="mt-12 grid gap-5 md:grid-cols-2">
          {useCases.map((u, i) => (
            <Reveal key={u.title} delay={(i % 2) * 0.08}>
              <SpotlightCard className="h-full p-8">
                <p className="text-sm font-bold text-accent-strong dark:text-accent">{u.area}</p>
                <p className="mt-5 flex items-baseline gap-3">
                  <span className="text-xl font-semibold text-muted line-through decoration-2">{u.before}</span>
                  <ArrowRight size={18} weight="bold" className="text-accent" aria-label="to" />
                  <span className="text-4xl font-extrabold tracking-[-0.03em] text-fg">{u.after}</span>
                </p>
                <h3 className="mt-6 text-xl font-bold text-fg">{u.title}</h3>
                <p className="mt-2 leading-relaxed text-muted">{u.body}</p>
              </SpotlightCard>
            </Reveal>
          ))}
        </div>
      </section>

      <CtaBand
        title="See PlugIQ in action."
        body="15-minute demo. We'll show you exactly how PlugIQ would automate your most painful workflow."
        label="Request a Demo"
        href={demo}
      />
    </>
  );
}
