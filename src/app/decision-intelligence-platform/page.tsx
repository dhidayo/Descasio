import type { Metadata } from "next";
import {
  Target, TrendUp, Gauge, Trophy, PlugsConnected, CheckSquareOffset, Path, ShieldCheck, ChartLineUp, Check, CalendarStar, ArrowRight,
} from "@phosphor-icons/react/dist/ssr";
import { dip, outcomes, problems, steps, scores, foundingCircle, launchEvent } from "@/content/dip";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { SpotlightCard } from "@/components/ui/SpotlightCard";
import { CtaBand } from "@/components/ui/CtaBand";
import { EvidenceTrail } from "@/components/dip/EvidenceTrail";
import { IndustryTabs } from "@/components/dip/IndustryTabs";

export const metadata: Metadata = {
  title: "Decision Intelligence Platform (DIP)",
  description: dip.intro,
};

const outcomeIcons = { target: Target, trend: TrendUp, gauge: Gauge, trophy: Trophy };
const stepIcons = { plugs: PlugsConnected, check: CheckSquareOffset, path: Path, shield: ShieldCheck, chart: ChartLineUp };

export default function DIPPage() {
  return (
    <>
      {/* Hero: proposition left, the evidence trail right */}
      <section className="mx-auto grid max-w-6xl items-center gap-12 px-4 pb-16 pt-36 md:pt-40 lg:grid-cols-[1.15fr_0.85fr]">
        <Reveal>
          <span className="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-bold text-accent-strong dark:text-accent">
            Decision Intelligence Platform
          </span>
          <h1 className="mt-6 text-balance text-[2.6rem] font-extrabold leading-[1.03] tracking-[-0.04em] text-fg md:text-6xl">
            Turn fragmented data into decisions <span className="text-accent-strong dark:text-accent">you can trust.</span>
          </h1>
          <p className="mt-6 max-w-[52ch] text-lg leading-relaxed text-muted md:text-xl">{dip.intro}</p>
          <div className="mt-9 flex flex-wrap gap-3">
            <Button href={dip.assessmentHref}>Request Your Assessment</Button>
            <Button href="#founding-circle" variant="glass" arrow={false}>
              Founding Circle
            </Button>
          </div>
          <p className="mt-5 max-w-md text-sm leading-relaxed text-muted">{dip.assessmentNote}</p>
        </Reveal>
        <Reveal delay={0.1}>
          <EvidenceTrail />
        </Reveal>
      </section>

      {/* Outcomes: 2 x 2 */}
      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <SectionHeading title="Make your next big decision with data intelligence." />
        </Reveal>
        <div className="mt-12 grid gap-5 sm:grid-cols-2">
          {outcomes.map((o, i) => {
            const Icon = outcomeIcons[o.icon];
            return (
              <Reveal key={o.title} delay={(i % 2) * 0.07}>
                <SpotlightCard className="flex h-full gap-5 p-7">
                  <span className="grid size-12 shrink-0 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">
                    <Icon size={26} weight="duotone" />
                  </span>
                  <div>
                    <h3 className="text-xl font-bold text-fg">{o.title}</h3>
                    <p className="mt-2 leading-relaxed text-muted">{o.body}</p>
                  </div>
                </SpotlightCard>
              </Reveal>
            );
          })}
        </div>
      </section>

      {/* Problem: accent panel */}
      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <div className="relative overflow-hidden rounded-[32px] bg-accent-strong p-8 text-white md:p-14">
            <h2 className="max-w-2xl text-balance text-3xl font-extrabold leading-[1.08] tracking-[-0.03em] md:text-5xl">
              Your business is only as reliable as the data behind it.
            </h2>
            <p className="mt-5 max-w-2xl text-lg leading-relaxed text-white/85">
              Critical decisions are made every day using data spread across systems, spreadsheets, and teams. When accuracy, accountability, or
              compliance is questioned, most organisations discover they lack the visibility to respond with confidence.
            </p>
            <div className="mt-12 grid gap-8 md:grid-cols-3">
              {problems.map((p) => (
                <div key={p.title} className="border-t border-white/30 pt-6">
                  <h3 className="text-xl font-bold">{p.title}</h3>
                  <p className="mt-2 leading-relaxed text-white/85">{p.body}</p>
                </div>
              ))}
            </div>
          </div>
        </Reveal>
      </section>

      {/* How it works: connected steps */}
      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <SectionHeading
            title="From raw data to trusted decisions."
            body="DIP creates a governed data foundation that connects your critical systems, enforces quality and governance controls, and delivers insights you can trust, with complete visibility from source to outcome."
          />
        </Reveal>
        <ol className="relative mt-14 grid gap-8 lg:grid-cols-5 lg:gap-5">
          <span aria-hidden className="absolute left-[10%] right-[10%] top-7 hidden h-0.5 bg-gradient-to-r from-accent/20 via-accent to-accent/20 lg:block" />
          {steps.map((s, i) => {
            const Icon = stepIcons[s.icon];
            return (
              <Reveal key={s.title} delay={i * 0.08}>
                <li className="relative flex gap-5 lg:block lg:text-center">
                  <span className="relative z-10 grid size-14 shrink-0 place-items-center rounded-full bg-accent-strong text-white shadow-[0_10px_30px_-10px_rgb(198_59_28/0.7)] lg:mx-auto">
                    <Icon size={26} weight="duotone" />
                  </span>
                  <div className="lg:mt-6">
                    <h3 className="text-lg font-bold text-fg">{s.title}</h3>
                    <p className="mt-2 text-[15px] leading-relaxed text-muted">{s.body}</p>
                  </div>
                </li>
              </Reveal>
            );
          })}
        </ol>
      </section>

      {/* Who it's for: tabs */}
      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <SectionHeading
            title="Built for organisations where every number matters."
            body="DIP is designed for highly regulated and data-intensive enterprises that need confidence in their reporting, governance, and AI readiness."
          />
        </Reveal>
        <Reveal className="mt-10">
          <IndustryTabs />
        </Reveal>
      </section>

      {/* Executive assessment: three scores */}
      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <div className="glass rounded-[32px] p-8 md:p-12">
            <div className="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
              <div>
                <p className="text-sm font-bold text-accent-strong dark:text-accent">Free executive assessment</p>
                <h2 className="mt-3 text-3xl font-extrabold leading-tight tracking-[-0.03em] text-fg md:text-4xl">
                  Measure the strength of your data foundation.
                </h2>
                <p className="mt-4 leading-relaxed text-muted">
                  Get a clear score across three dimensions, then talk to our team about what it means for your organisation. No obligation required.
                </p>
                <Button href={dip.assessmentHref} className="mt-8">
                  Speak With a Data Specialist
                </Button>
              </div>
              <ol className="grid gap-4">
                {scores.map((s, i) => (
                  <li key={s.title} className="flex gap-5 rounded-[18px] border border-line bg-[var(--bg-elevated)]/60 p-5">
                    <span className="text-3xl font-extrabold tracking-tighter text-accent">{i + 1}</span>
                    <div>
                      <h3 className="font-bold text-fg">{s.title}</h3>
                      <p className="mt-1 text-[15px] leading-relaxed text-muted">{s.body}</p>
                    </div>
                  </li>
                ))}
              </ol>
            </div>
          </div>
        </Reveal>
      </section>

      {/* Founding Circle + launch event */}
      <section id="founding-circle" className="mx-auto grid max-w-6xl scroll-mt-28 gap-5 px-4 py-16 lg:grid-cols-[1.3fr_0.7fr]">
        <Reveal>
          <div className="glass h-full rounded-[28px] p-8 md:p-10">
            <div className="flex flex-wrap items-center gap-2">
              <span className="text-sm font-bold text-accent-strong dark:text-accent">Founding Circle</span>
              <span className="rounded-full border border-line px-3 py-1 text-xs font-semibold text-muted">Limited availability</span>
            </div>
            <h2 className="mt-4 text-3xl font-extrabold leading-tight tracking-[-0.03em] text-fg">{foundingCircle.title}</h2>
            <p className="mt-4 max-w-xl leading-relaxed text-muted">{foundingCircle.body}</p>
            <ul className="mt-7 grid gap-3 sm:grid-cols-2">
              {foundingCircle.perks.map((p) => (
                <li key={p} className="flex items-start gap-3 font-medium text-fg">
                  <span className="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-accent text-white">
                    <Check size={13} weight="bold" />
                  </span>
                  {p}
                </li>
              ))}
            </ul>
            <Button href={foundingCircle.href} className="mt-9">
              Apply for the Founding Circle
            </Button>
          </div>
        </Reveal>
        <Reveal delay={0.08}>
          <div className="relative flex h-full flex-col justify-between overflow-hidden rounded-[28px] bg-fg p-8 text-[var(--bg)]">
            <div>
              <CalendarStar size={32} weight="duotone" className="text-accent" />
              <p className="mt-6 text-sm font-bold text-accent">Launch event, Lagos</p>
              <h2 className="mt-2 text-3xl font-extrabold tracking-tight">{launchEvent.name}</h2>
              <p className="mt-3 leading-relaxed opacity-80">{launchEvent.description}</p>
              <p className="mt-2 leading-relaxed opacity-80">{launchEvent.detail}</p>
            </div>
            <a href={launchEvent.href} className="mt-8 inline-flex items-center gap-2 font-semibold text-accent">
              Reserve a seat <ArrowRight size={16} weight="bold" />
            </a>
          </div>
        </Reveal>
      </section>

      <CtaBand
        title="Make your next big decision with data you can defend."
        body="Experience DIP through a Proof of Concept with no initial commitment. Explore its capabilities and identify practical use cases for your organisation."
        label="Request Your Assessment"
        href={dip.assessmentHref}
      />
    </>
  );
}
