import type { Metadata } from "next";
import { ArrowUpRight } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { CtaBand } from "@/components/ui/CtaBand";
import { caseStudies } from "@/content/site";

export const metadata: Metadata = {
  title: "Case Studies",
  description: "See how we've helped enterprises across energy, finance, logistics, and government modernise operations and accelerate growth.",
};

export default function CaseStudies() {
  return (
    <>
      <PageHero
        label="Case studies"
        title={
          <>
            Real impact. <span className="text-accent-strong dark:text-accent">Real results.</span>
          </>
        }
        intro="See how we've helped enterprises across energy, finance, logistics, and government modernise operations and accelerate growth."
      />
      <section className="mx-auto max-w-6xl px-4 py-12">
        <div className="grid gap-5 md:grid-cols-2">
          {caseStudies.map((c, i) => {
            const inner = (
              <>
                <div>
                  <p className="text-sm font-bold text-accent-strong dark:text-accent">{c.sector}</p>
                  <h2 className="mt-3 text-xl font-bold leading-snug text-fg md:text-2xl">{c.title}</h2>
                  <p className="mt-3 leading-relaxed text-muted">{c.summary}</p>
                </div>
                {c.metrics.length > 0 ? (
                  <dl className="mt-8 grid grid-cols-2 gap-6 border-t border-line pt-6">
                    {c.metrics.map((m) => (
                      <div key={m.label}>
                        <dd className="text-3xl font-extrabold tracking-[-0.03em] text-fg">{m.value}</dd>
                        <dt className="mt-1 text-sm text-muted">{m.label}</dt>
                      </div>
                    ))}
                  </dl>
                ) : (
                  <span className="mt-8 inline-flex items-center gap-1 border-t border-line pt-6 font-semibold text-fg">
                    Read case study <ArrowUpRight size={16} weight="bold" />
                  </span>
                )}
              </>
            );
            const cls = "glass flex h-full flex-col justify-between rounded-[var(--radius-card)] p-8";
            return (
              <Reveal key={c.title} delay={(i % 2) * 0.07}>
                {c.href ? (
                  <a href={c.href} target="_blank" rel="noopener noreferrer" className={`${cls} transition-transform duration-500 hover:-translate-y-1`}>
                    {inner}
                  </a>
                ) : (
                  <article className={cls}>{inner}</article>
                )}
              </Reveal>
            );
          })}
        </div>
      </section>
      <CtaBand />
    </>
  );
}
