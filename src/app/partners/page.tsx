import type { Metadata } from "next";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { CheckList } from "@/components/ui/CheckList";
import { CtaBand } from "@/components/ui/CtaBand";
import { alliances, partners } from "@/content/site";

export const metadata: Metadata = {
  title: "Partners",
  description: "We partner with the world's leading technology companies to deliver enterprise-grade solutions with deep African market expertise.",
};

export default function Partners() {
  return (
    <>
      <PageHero
        label="Partners"
        title={
          <>
            Global partnerships. <span className="text-accent-strong dark:text-accent">Local delivery.</span>
          </>
        }
        intro="We partner with the world's leading technology companies to deliver enterprise-grade solutions with deep African market expertise."
      >
        <ul className="flex flex-wrap gap-2">
          {alliances.map((a) => (
            <li key={a} className="glass rounded-full px-5 py-2 font-semibold text-fg">
              {a}
            </li>
          ))}
        </ul>
      </PageHero>

      <section className="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12">
        {partners.map((p) => (
          <Reveal key={p.name}>
            <article className="glass grid gap-8 rounded-[28px] p-8 md:grid-cols-[1.2fr_0.8fr] md:p-12">
              <div>
                <p className="text-sm font-bold text-accent-strong dark:text-accent">{p.area}</p>
                <h2 className="mt-3 text-3xl font-extrabold tracking-tight text-fg md:text-4xl">Descasio + {p.name}</h2>
                <p className="mt-4 max-w-xl text-lg leading-relaxed text-muted">{p.body}</p>
                <ul className="mt-6 flex flex-wrap gap-2">
                  {p.badges.map((b) => (
                    <li key={b} className="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-semibold text-accent-strong dark:text-accent">
                      {b}
                    </li>
                  ))}
                </ul>
              </div>
              <div className="rounded-[var(--radius-card)] border border-line bg-[var(--bg-elevated)]/50 p-7">
                <h3 className="font-bold text-fg">{p.name === "Security Partners" ? "Security stack" : "Joint capabilities"}</h3>
                <CheckList items={p.capabilities} className="mt-5 text-[15px]" />
              </div>
            </article>
          </Reveal>
        ))}
      </section>

      <CtaBand />
    </>
  );
}
