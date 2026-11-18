import Link from "next/link";
import { ArrowRight, Briefcase, CloudArrowUp, FlowArrow } from "@phosphor-icons/react/dist/ssr";
import { layers } from "@/content/site";
import { Reveal } from "@/components/ui/Reveal";
import { SpotlightCard } from "@/components/ui/SpotlightCard";

const icons = { briefcase: Briefcase, cloud: CloudArrowUp, flow: FlowArrow };

export function Layers() {
  return (
    <section className="mx-auto grid max-w-6xl gap-10 px-4 py-24 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
      <div className="lg:sticky lg:top-32 lg:self-start">
        <Reveal>
          <h2 className="text-[2.4rem] font-extrabold leading-[1.04] tracking-[-0.035em] text-fg md:text-6xl">
            Three layers.
            <br />
            One partner.
            <br />
            <span className="text-accent-strong dark:text-accent">Zero handoffs.</span>
          </h2>
          <p className="mt-6 max-w-[46ch] text-lg leading-relaxed text-muted">
            Most partners advise or build or manage. We do all three, on infrastructure we own, with a platform we built.
            That&apos;s why enterprises trust us with their most critical systems.
          </p>
        </Reveal>
      </div>
      <div className="flex flex-col gap-5">
        {layers.map((l, i) => {
          const Icon = icons[l.icon];
          return (
            <Reveal key={l.n} delay={i * 0.08}>
              <SpotlightCard className="p-7 md:p-9">
                <div className="flex items-start justify-between gap-6">
                  <span className="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">
                    <Icon size={26} weight="duotone" />
                  </span>
                  <span className="text-5xl font-extrabold tracking-tighter text-fg/10">{l.n}</span>
                </div>
                <h3 className="mt-6 text-2xl font-bold tracking-tight text-fg">{l.title}</h3>
                <p className="mt-3 leading-relaxed text-muted">{l.body}</p>
                <Link href={l.cta.href} className="mt-6 inline-flex items-center gap-1.5 font-semibold text-accent-strong dark:text-accent">
                  {l.cta.label}
                  <ArrowRight size={16} weight="bold" className="transition-transform group-hover:translate-x-1" />
                </Link>
              </SpotlightCard>
            </Reveal>
          );
        })}
      </div>
    </section>
  );
}
