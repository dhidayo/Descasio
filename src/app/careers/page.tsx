import type { Metadata } from "next";
import { ArrowUpRight } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { SectionHeading } from "@/components/ui/SectionHeading";
import { CtaBand } from "@/components/ui/CtaBand";
import { company, roles } from "@/content/site";

export const metadata: Metadata = {
  title: "Careers",
  description: "Build Africa's digital infrastructure with us. A team of 60+ engineers, consultants, and operators.",
};

export default function Careers() {
  return (
    <>
      <PageHero
        label="Careers"
        title={
          <>
            Build Africa&apos;s digital infrastructure <span className="text-accent-strong dark:text-accent">with us.</span>
          </>
        }
        intro="We're a team of 60+ engineers, consultants, and operators who believe technology should work for Africa, not just in Africa."
      />

      <section className="mx-auto grid max-w-6xl gap-10 px-4 py-12 lg:grid-cols-[0.8fr_1.2fr]">
        <Reveal className="lg:sticky lg:top-28 lg:self-start">
          <SectionHeading
            title="Work that matters."
            body="We're not building another SaaS tool for Silicon Valley. We're building the cloud, the automation, and the advisory practice that African enterprises depend on. The work is hard, the impact is real."
          />
        </Reveal>
        <div>
          <h2 className="sr-only">Open roles</h2>
          <ul className="flex flex-col gap-3">
            {roles.map((r, i) => (
              <Reveal key={r.title} delay={i * 0.04}>
                <li>
                  <a
                    href={`mailto:${company.email}?subject=${encodeURIComponent(`Application: ${r.title}`)}`}
                    className="glass group flex items-center justify-between gap-4 rounded-[var(--radius-card)] px-6 py-5 transition-transform duration-500 hover:-translate-y-0.5"
                  >
                    <div>
                      <p className="text-lg font-bold text-fg">{r.title}</p>
                      <p className="mt-1 text-[15px] text-muted">
                        {r.team}, {r.location}. Full-time
                      </p>
                    </div>
                    <span className="inline-flex shrink-0 items-center gap-1 font-semibold text-accent-strong dark:text-accent">
                      Apply
                      <ArrowUpRight size={16} weight="bold" className="transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                    </span>
                  </a>
                </li>
              </Reveal>
            ))}
          </ul>
        </div>
      </section>

      <CtaBand
        title="Don't see your role?"
        body="We're always looking for exceptional people. Send us your CV and tell us what you'd build."
        label="Send Your CV"
        href={`mailto:${company.email}?subject=${encodeURIComponent("CV submission")}`}
      />
    </>
  );
}
