import type { Metadata } from "next";
import { EnvelopeSimple, Phone, MapPin, Clock } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { ContactForm } from "@/components/forms/ContactForm";
import { company } from "@/content/site";

export const metadata: Metadata = {
  title: "Contact",
  description: "Book a strategy session or tell us about your project. No pitch deck. No pressure. Just a real conversation.",
};

export default async function Contact({ searchParams }: { searchParams: Promise<{ topic?: string }> }) {
  const { topic } = await searchParams;
  const details = [
    { icon: EnvelopeSimple, label: "Email", value: company.email, href: `mailto:${company.email}` },
    { icon: Phone, label: "Phone", value: company.phone, href: company.phoneHref },
    { icon: MapPin, label: "Office", value: company.address },
  ];
  return (
    <>
      <PageHero
        label="Get in touch"
        title={
          <>
            Let&apos;s talk about what <span className="text-accent-strong dark:text-accent">you&apos;re building.</span>
          </>
        }
        intro="Book a strategy session or tell us about your project. No pitch deck. No pressure. Just a real conversation."
      />
      <section className="mx-auto grid max-w-6xl gap-6 px-4 py-8 lg:grid-cols-[0.8fr_1.2fr]">
        <Reveal>
          <div className="glass h-full rounded-[var(--radius-card)] p-8">
            <h2 className="text-2xl font-extrabold tracking-tight text-fg">How we can help.</h2>
            <p className="mt-3 leading-relaxed text-muted">
              Whether you&apos;re modernising infrastructure, automating operations, or planning an AI transformation, our team will help you
              identify the highest-impact starting point.
            </p>
            <ul className="mt-8 space-y-5">
              {details.map((d) => {
                const Icon = d.icon;
                const body = (
                  <>
                    <span className="grid size-11 shrink-0 place-items-center rounded-2xl bg-accent-soft text-accent-strong dark:text-accent">
                      <Icon size={22} weight="duotone" />
                    </span>
                    <span>
                      <span className="block text-sm text-muted">{d.label}</span>
                      <span className="block font-semibold text-fg">{d.value}</span>
                    </span>
                  </>
                );
                return (
                  <li key={d.label}>
                    {d.href ? <a href={d.href} className="flex items-center gap-4">{body}</a> : <div className="flex items-center gap-4">{body}</div>}
                  </li>
                );
              })}
            </ul>
            <p className="mt-8 flex gap-3 rounded-[14px] border border-line p-4 text-[15px] leading-relaxed text-muted">
              <Clock size={20} weight="duotone" className="mt-0.5 shrink-0 text-accent" />
              <span>
                <strong className="text-fg">Typical response time:</strong> within 4 business hours. For urgent infrastructure issues, call us directly.
              </span>
            </p>
          </div>
        </Reveal>
        <Reveal delay={0.08}>
          <div className="glass rounded-[var(--radius-card)] p-8 md:p-10">
            <ContactForm defaultTopic={topic} />
          </div>
        </Reveal>
      </section>
    </>
  );
}
