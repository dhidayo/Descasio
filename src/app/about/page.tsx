import type { Metadata } from "next";
import Image from "next/image";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { CtaBand } from "@/components/ui/CtaBand";
import { board, leadership, values } from "@/content/site";

export const metadata: Metadata = {
  title: "About Us",
  description: "Founded in 2010, Descasio pioneered cloud adoption in Nigeria. Today we serve 400+ organisations across energy, finance, retail, and the public sector.",
};

export default function About() {
  return (
    <>
      <PageHero
        label="About Descasio"
        title={
          <>
            15 years of building <span className="text-accent-strong dark:text-accent">Africa&apos;s digital infrastructure.</span>
          </>
        }
        intro="Founded in 2010 by Dele Nedd and Femi Olugbesan, Descasio pioneered cloud adoption in Nigeria when most businesses had never heard the word. Today we serve 400+ organisations across energy, finance, retail, and the public sector."
      />

      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <SectionHeading title="What drives us every day." />
        </Reveal>
        <div className="mt-12 grid gap-x-10 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
          {values.map((v, i) => (
            <Reveal key={v.title} delay={(i % 3) * 0.06}>
              <div className="border-t-2 border-accent pt-6">
                <h3 className="text-xl font-bold text-fg">{v.title}</h3>
                <p className="mt-3 leading-relaxed text-muted">{v.body}</p>
              </div>
            </Reveal>
          ))}
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16">
        <Reveal>
          <SectionHeading title="The team behind Descasio." />
        </Reveal>
        <div className="mt-12 grid gap-5 sm:grid-cols-3">
          {leadership.map((p, i) => (
            <Reveal key={p.name} delay={i * 0.07}>
              <figure className="glass overflow-hidden rounded-[var(--radius-card)] p-2">
                <div className="relative aspect-[4/3] overflow-hidden rounded-[16px] bg-[var(--bg-elevated)]">
                  <Image src={p.img} alt={p.name} fill sizes="(min-width: 640px) 33vw, 100vw" className="object-cover object-top" />
                </div>
                <figcaption className="px-4 pb-4 pt-5">
                  <p className="text-lg font-bold text-fg">{p.name}</p>
                  <p className="text-[15px] text-muted">{p.role}</p>
                </figcaption>
              </figure>
            </Reveal>
          ))}
        </div>

        <Reveal>
          <h3 className="mt-20 text-2xl font-extrabold tracking-tight text-fg">Board of Directors</h3>
        </Reveal>
        <div className="mt-8 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">
          {board.map((p, i) => (
            <Reveal key={p.name} delay={i * 0.05}>
              <figure className="text-center">
                <div className="relative mx-auto aspect-square w-full max-w-[180px] overflow-hidden rounded-full ring-4 ring-white/70 dark:ring-white/10">
                  <Image src={p.img} alt={p.name} fill sizes="180px" className="object-cover" />
                </div>
                <figcaption className="mt-4">
                  <p className="font-bold text-fg">{p.name}</p>
                  <p className="text-sm text-muted">{p.role}</p>
                </figcaption>
              </figure>
            </Reveal>
          ))}
        </div>
      </section>

      <CtaBand
        title="Want to join the team?"
        body="We're always looking for sharp engineers, consultants, and operators who want to build Africa's digital infrastructure."
        label="View Open Roles"
        href="/careers"
      />
    </>
  );
}
