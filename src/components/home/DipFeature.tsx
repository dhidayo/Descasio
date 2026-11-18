import { Target, TrendUp, Gauge, Trophy } from "@phosphor-icons/react/dist/ssr";
import { dip, outcomes } from "@/content/dip";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { EvidenceTrail } from "@/components/dip/EvidenceTrail";

const icons = { target: Target, trend: TrendUp, gauge: Gauge, trophy: Trophy };

/** Home page flagship band for the Decision Intelligence Platform. */
export function DipFeature() {
  return (
    <section className="mx-auto max-w-6xl px-4 pt-24" aria-labelledby="dip-heading">
      <Reveal>
        <div className="glass relative overflow-hidden rounded-[32px] p-7 md:p-12">
          <div aria-hidden className="pointer-events-none absolute -right-32 -top-32 size-96 rounded-full bg-[radial-gradient(circle,var(--blob-a),transparent_65%)] blur-2xl" />
          <div className="relative grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
            <div>
              <p className="text-sm font-bold text-accent-strong dark:text-accent">Our flagship platform</p>
              <h2 id="dip-heading" className="mt-3 text-balance text-[2.2rem] font-extrabold leading-[1.05] tracking-[-0.035em] text-fg md:text-5xl">
                Decisions you can trust, from data you can defend.
              </h2>
              <p className="mt-5 max-w-[52ch] text-lg leading-relaxed text-muted">
                The Decision Intelligence Platform connects, governs, and monitors your critical data, so every report and AI initiative stands on
                evidence.
              </p>
              <ul className="mt-8 grid gap-4 sm:grid-cols-2">
                {outcomes.map((o) => {
                  const Icon = icons[o.icon];
                  return (
                    <li key={o.title} className="flex items-center gap-3">
                      <span className="grid size-10 shrink-0 place-items-center rounded-xl bg-accent-soft text-accent-strong dark:text-accent">
                        <Icon size={20} weight="duotone" />
                      </span>
                      <span className="font-semibold leading-snug text-fg">{o.title}</span>
                    </li>
                  );
                })}
              </ul>
              <div className="mt-10 flex flex-wrap gap-3">
                <Button href={dip.href}>Explore DIP</Button>
                <Button href={dip.assessmentHref} variant="glass" arrow={false}>
                  Request Your Assessment
                </Button>
              </div>
            </div>
            <EvidenceTrail className="!bg-[var(--bg-elevated)]/70" />
          </div>
        </div>
      </Reveal>
    </section>
  );
}
