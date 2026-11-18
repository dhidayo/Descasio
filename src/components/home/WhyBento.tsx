import Image from "next/image";
import { Buildings, GlobeHemisphereEast, Handshake, Lightning } from "@phosphor-icons/react/dist/ssr";
import { alliances, differentiators } from "@/content/site";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { SpotlightCard } from "@/components/ui/SpotlightCard";

const icons = { buildings: Buildings, lightning: Lightning, handshake: Handshake, globe: GlobeHemisphereEast };

export function WhyBento() {
  const [own, built, alliance, focus] = differentiators;
  const Icon = (k: keyof typeof icons) => {
    const I = icons[k];
    return <I size={26} weight="duotone" />;
  };
  return (
    <section className="mx-auto max-w-6xl px-4 py-24">
      <Reveal>
        <SectionHeading
          title="What sets us apart from the alternatives."
          body="Not another IT reseller. Not a Big 4 report factory. Here's why enterprises choose us."
        />
      </Reveal>

      <div className="mt-14 grid gap-5 md:grid-cols-6">
        {/* Large, accent-filled cell */}
        <Reveal className="md:col-span-4">
          <div className="relative h-full overflow-hidden rounded-[var(--radius-card)] bg-accent-strong p-8 text-white md:p-10">
            <Image src="/brand/descasio-mark.svg" unoptimized alt="" width={225} height={225} className="pointer-events-none absolute -right-16 -bottom-16 size-72 opacity-25 mix-blend-screen" />
            <span className="grid size-12 place-items-center rounded-2xl bg-white/15">{Icon(own.icon)}</span>
            <h3 className="mt-8 max-w-md text-3xl font-extrabold tracking-tight">{own.title}</h3>
            <p className="mt-3 max-w-lg leading-relaxed text-white/85">{own.body}</p>
          </div>
        </Reveal>

        <Reveal className="md:col-span-2" delay={0.08}>
          <SpotlightCard className="h-full p-8">
            <span className="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">{Icon(built.icon)}</span>
            <h3 className="mt-8 text-xl font-bold tracking-tight text-fg">{built.title}</h3>
            <p className="mt-3 leading-relaxed text-muted">{built.body}</p>
          </SpotlightCard>
        </Reveal>

        <Reveal className="md:col-span-2" delay={0.04}>
          <SpotlightCard className="h-full p-8">
            <span className="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">{Icon(focus.icon)}</span>
            <h3 className="mt-8 text-xl font-bold tracking-tight text-fg">{focus.title}</h3>
            <p className="mt-3 leading-relaxed text-muted">{focus.body}</p>
          </SpotlightCard>
        </Reveal>

        {/* Alliances cell: the partner names are the content */}
        <Reveal className="md:col-span-4" delay={0.1}>
          <SpotlightCard className="h-full p-8 md:p-10">
            <span className="grid size-12 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">{Icon(alliance.icon)}</span>
            <h3 className="mt-8 text-xl font-bold tracking-tight text-fg">{alliance.title}</h3>
            <p className="mt-3 max-w-xl leading-relaxed text-muted">{alliance.body}</p>
            <ul className="mt-6 flex flex-wrap gap-2">
              {alliances.map((a) => (
                <li key={a} className="rounded-full border border-line bg-[var(--bg-elevated)]/60 px-4 py-1.5 text-sm font-semibold text-fg">
                  {a}
                </li>
              ))}
            </ul>
          </SpotlightCard>
        </Reveal>
      </div>
    </section>
  );
}
