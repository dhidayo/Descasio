import type { ReactNode } from "react";
import { Reveal } from "./Reveal";

/** Inner-page hero: short label, headline, intro, optional actions. Left-aligned. */
export function PageHero({
  label,
  title,
  intro,
  status,
  children,
}: {
  label?: string;
  title: ReactNode;
  intro?: ReactNode;
  status?: string;
  children?: ReactNode;
}) {
  return (
    <section className="mx-auto max-w-6xl px-4 pb-12 pt-36 md:pt-44">
      <Reveal>
        {(label || status) && (
          <div className="flex flex-wrap items-center gap-2">
            {label && (
              <span className="rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-bold text-accent-strong dark:text-accent">{label}</span>
            )}
            {status && <span className="glass rounded-full px-3.5 py-1.5 text-sm font-semibold text-fg">{status}</span>}
          </div>
        )}
        <h1 className="mt-6 max-w-4xl text-balance text-[2.6rem] font-extrabold leading-[1.04] tracking-[-0.04em] text-fg md:text-6xl lg:text-[4.2rem]">
          {title}
        </h1>
        {intro && <p className="mt-6 max-w-[58ch] text-lg leading-relaxed text-muted md:text-xl">{intro}</p>}
        {children && <div className="mt-9 flex flex-wrap gap-3">{children}</div>}
      </Reveal>
    </section>
  );
}
