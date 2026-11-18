import Link from "next/link";
import { ArrowUpRight } from "@phosphor-icons/react/dist/ssr";
import { caseStudies } from "@/content/site";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { Button } from "@/components/ui/Button";

export function Results() {
  const [featured, ...rest] = caseStudies;
  const articles = rest.slice(0, 2);
  return (
    <section className="mx-auto max-w-6xl px-4 py-24">
      <Reveal>
        <SectionHeading title="Real outcomes for real enterprises." body="We don't hide behind anonymity. Here's what delivery looks like." />
      </Reveal>
      <div className="mt-14 grid gap-5 lg:grid-cols-[1.25fr_1fr]">
        <Reveal>
          <article className="glass flex h-full flex-col justify-between rounded-[var(--radius-card)] p-8 md:p-10">
            <div>
              <p className="text-sm font-bold text-accent-strong dark:text-accent">{featured.sector}</p>
              <h3 className="mt-3 text-3xl font-extrabold leading-tight tracking-tight text-fg">{featured.title}</h3>
              <p className="mt-4 max-w-lg leading-relaxed text-muted">{featured.summary}</p>
            </div>
            <dl className="mt-10 grid grid-cols-2 gap-6 border-t border-line pt-8">
              {featured.metrics.map((m) => (
                <div key={m.label}>
                  <dt className="text-sm text-muted">{m.label}</dt>
                  <dd className="mt-1 text-5xl font-extrabold tracking-[-0.04em] text-fg">{m.value}</dd>
                </div>
              ))}
            </dl>
          </article>
        </Reveal>
        <div className="flex flex-col gap-5">
          {articles.map((a, i) => (
            <Reveal key={a.title} delay={0.08 * (i + 1)} className="flex-1">
              <Link href={a.href ?? "/case-studies"} target="_blank" rel="noopener noreferrer" className="glass group flex h-full flex-col justify-between rounded-[var(--radius-card)] p-7 transition-transform duration-500 hover:-translate-y-1">
                <div>
                  <p className="text-sm font-bold text-accent-strong dark:text-accent">{a.sector}</p>
                  <h3 className="mt-2 text-lg font-bold leading-snug text-fg">{a.title}</h3>
                </div>
                <span className="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-fg">
                  Read case study
                  <ArrowUpRight size={15} weight="bold" className="transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                </span>
              </Link>
            </Reveal>
          ))}
        </div>
      </div>
      <div className="mt-10">
        <Button href="/case-studies" variant="glass">All case studies</Button>
      </div>
    </section>
  );
}
