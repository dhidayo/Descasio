import type { Service } from "@/content/services";
import { ctas } from "@/content/site";
import { PageHero } from "@/components/ui/PageHero";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { CheckList } from "@/components/ui/CheckList";
import { AssessmentPromo } from "@/components/ui/AssessmentPromo";
import { CtaBand } from "@/components/ui/CtaBand";

export function ServiceView({ s }: { s: Service }) {

  return (
    <>
      <PageHero label={s.category} status={s.status} title={s.title} intro={s.intro}>
        <Button href={ctas.primary.href}>{s.cta}</Button>
      </PageHero>

      <section className="mx-auto grid max-w-6xl gap-8 px-4 py-12 lg:grid-cols-[1.35fr_0.85fr] lg:gap-12">
        <div className="flex flex-col gap-5">
          {s.blocks.map((b, i) => (
            <Reveal key={b.title} delay={i * 0.04}>
              <article className="glass rounded-[var(--radius-card)] p-7 md:p-9">
                <h2 className="text-2xl font-extrabold tracking-tight text-fg md:text-[1.7rem]">{b.title}</h2>
                {Array.isArray(b.body) ? (
                  <CheckList items={b.body} className="mt-5" />
                ) : (
                  <p className="mt-4 text-[17px] leading-relaxed text-muted">{b.body}</p>
                )}
              </article>
            </Reveal>
          ))}
        </div>

        {(s.lists.length > 0 || s.assessment) && (
          <aside className="flex flex-col gap-5 lg:sticky lg:top-28 lg:self-start">
            {s.lists.map((l, i) => (
              <Reveal key={l.title} delay={0.08 + i * 0.06}>
                <div className="glass rounded-[var(--radius-card)] p-7">
                  <h2 className="text-lg font-bold text-fg">{l.title}</h2>
                  <CheckList items={l.items} className="mt-5 text-[15px]" />
                </div>
              </Reveal>
            ))}
            {s.assessment && (
              <Reveal delay={0.2}>
                <AssessmentPromo />
              </Reveal>
            )}
          </aside>
        )}
      </section>

      <CtaBand
        title="Not sure where to start?"
        body="Our team will help you identify the highest-impact opportunity and build a phased roadmap."
      />
    </>
  );
}
