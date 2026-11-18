import type { Metadata } from "next";
import { CalendarBlank } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Button } from "@/components/ui/Button";

export const metadata: Metadata = { title: "Events", description: "Conferences, panels, webinars, and meetups. Come talk cloud, AI, and enterprise technology with us." };

export default function Events() {
  return (
    <>
      <PageHero label="Events" title={<>Where we&apos;ll be <span className="text-accent-strong dark:text-accent">next.</span></>} intro="Conferences, panels, webinars, and meetups. Come talk cloud, AI, and enterprise technology with us." />
      <section className="mx-auto max-w-6xl px-4 py-8">
        <div className="glass flex flex-col items-start gap-4 rounded-[28px] p-10 md:p-14">
          <span className="grid size-14 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">
            <CalendarBlank size={28} weight="duotone" />
          </span>
          <h2 className="text-2xl font-extrabold text-fg">No upcoming events at the moment.</h2>
          <p className="max-w-lg leading-relaxed text-muted">Check back soon. In the meantime, read our latest thinking on the blog.</p>
          <Button href="/blog" variant="glass" className="mt-2">Read the blog</Button>
        </div>
      </section>
    </>
  );
}
