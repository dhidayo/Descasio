import type { Metadata } from "next";
import Link from "next/link";
import { ArrowRight, CalendarStar, MapPin, UsersThree } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Button } from "@/components/ui/Button";
import { Reveal } from "@/components/ui/Reveal";
import { launchEvent } from "@/content/dip";

export const metadata: Metadata = { title: "Events", description: "Conferences, panels, webinars, and meetups. Come talk cloud, AI, and enterprise technology with us." };

export default function Events() {
  return (
    <>
      <PageHero
        label="Events"
        title={<>Where we&apos;ll be <span className="text-accent-strong dark:text-accent">next.</span></>}
        intro="Conferences, panels, webinars, and meetups. Come talk cloud, AI, and enterprise technology with us."
      />
      <section className="mx-auto max-w-6xl px-4 py-8">
        <h2 className="text-xl font-bold text-fg">Upcoming</h2>
        <Reveal className="mt-6">
          <article className="glass grid gap-8 rounded-[28px] p-8 md:grid-cols-[auto_1fr_auto] md:items-center md:p-10">
            <span className="grid size-16 place-items-center rounded-2xl bg-accent-strong text-white">
              <CalendarStar size={32} weight="duotone" />
            </span>
            <div>
              <p className="text-sm font-bold text-accent-strong dark:text-accent">Flagship launch: Decision Intelligence Platform</p>
              <h3 className="mt-2 text-3xl font-extrabold tracking-tight text-fg">{launchEvent.name}</h3>
              <p className="mt-2 max-w-xl leading-relaxed text-muted">{launchEvent.detail}</p>
              <ul className="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-[15px] text-fg">
                <li className="flex items-center gap-2"><MapPin size={18} weight="duotone" className="text-accent" /> Lagos</li>
                <li className="flex items-center gap-2"><UsersThree size={18} weight="duotone" className="text-accent" /> Executive roundtable</li>
                <li className="flex items-center gap-2"><CalendarStar size={18} weight="duotone" className="text-accent" /> Date to be confirmed</li>
              </ul>
            </div>
            <Button href={launchEvent.href}>Reserve a seat</Button>
          </article>
        </Reveal>
        <Reveal className="mt-6">
          <Link href="/decision-intelligence-platform/" className="inline-flex items-center gap-2 font-semibold text-accent-strong dark:text-accent">
            Learn about the Decision Intelligence Platform <ArrowRight size={16} weight="bold" />
          </Link>
        </Reveal>
      </section>
    </>
  );
}
