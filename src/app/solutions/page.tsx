import type { Metadata } from "next";
import { CloudArrowUp, FlowArrow, Brain } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { CheckList } from "@/components/ui/CheckList";
import { CtaBand } from "@/components/ui/CtaBand";
import { ctas } from "@/content/site";

export const metadata: Metadata = {
  title: "Solutions",
  description: "Three integrated capability layers. One partner. From infrastructure through automation to advisory.",
};

const layers = [
  {
    label: "Infrastructure",
    icon: CloudArrowUp,
    title: "Sovereign AI Cloud & Modern Infrastructure",
    status: "Coming soon",
    body: "Run critical systems with full data sovereignty. Our in-country cloud is built for AI workloads, regulatory compliance, and enterprise-grade resilience.",
    points: ["In-country data residency compliant with NDPR", "GPU-enabled environments for AI/ML workloads", "Hybrid connectivity to AWS and Azure", "Enterprise-grade SLA with 99.9% uptime"],
    cta: { label: "Talk to an Infrastructure Expert", href: "/sovereign-cloud" },
  },
  {
    label: "Automation",
    icon: FlowArrow,
    title: "PlugIQ: Intelligent Workflow Automation",
    body: "Turn manual approvals, requisitions, and operations into automated, auditable workflows.",
    points: ["No-code: describe your process, PlugIQ builds it", "Multi-level approvals with full audit trail", "Connects to ERPs, CRMs, HRMS", "60% faster approval times on average"],
    cta: { label: "See PlugIQ in Action", href: "/plugiq" },
  },
  {
    label: "Advisory",
    icon: Brain,
    title: "AI Transformation Advisory",
    body: "We design execution-ready roadmaps that take AI initiatives from concept to production.",
    points: ["AI readiness assessments", "Business-aligned AI strategy", "Operating model redesign", "Responsible AI governance"],
    cta: { label: "Explore Advisory", href: "/ai-advisory" },
  },
];

export default function Solutions() {
  return (
    <>
      <PageHero
        label="Solutions"
        title="Technology built to transform how African enterprises operate, scale, and win."
        intro="Three integrated capability layers. One partner. From infrastructure through automation to advisory."
      >
        <Button href={ctas.primary.href}>{ctas.primary.label}</Button>
      </PageHero>

      <section className="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12">
        {layers.map((l, i) => {
          const Icon = l.icon;
          return (
            <Reveal key={l.title}>
              <article className="glass grid gap-10 rounded-[28px] p-8 md:grid-cols-[1.1fr_0.9fr] md:p-12">
                <div>
                  <div className="flex items-center gap-3">
                    <span className="grid size-12 place-items-center rounded-2xl bg-accent-strong text-white">
                      <Icon size={26} weight="duotone" />
                    </span>
                    <span className="text-sm font-bold text-accent-strong dark:text-accent">
                      0{i + 1} {l.label}
                    </span>
                    {l.status && <span className="rounded-full border border-line px-3 py-1 text-xs font-semibold text-muted">{l.status}</span>}
                  </div>
                  <h2 className="mt-7 text-3xl font-extrabold leading-tight tracking-tight text-fg md:text-4xl">{l.title}</h2>
                  <p className="mt-4 max-w-lg text-lg leading-relaxed text-muted">{l.body}</p>
                  <Button href={l.cta.href} variant="glass" className="mt-8">
                    {l.cta.label}
                  </Button>
                </div>
                <div className="self-center rounded-[var(--radius-card)] border border-line bg-[var(--bg-elevated)]/50 p-7">
                  <CheckList items={l.points} />
                </div>
              </article>
            </Reveal>
          );
        })}
      </section>

      <CtaBand title="Not sure where to start?" body="Our team will help you identify the highest-impact opportunity and build a phased roadmap." />
    </>
  );
}
