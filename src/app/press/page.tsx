import type { Metadata } from "next";
import { ArrowUpRight } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";

export const metadata: Metadata = { title: "Press", description: "Awards, media coverage, and press releases." };

// TODO(cms): source from the WordPress press_item type once detail pages are migrated.
const items = [
  { date: "February 2026", title: "Descasio Launches Africa's First Sovereign AI Cloud", body: "Enabling Nigerian enterprises to run AI workloads entirely in-country with enterprise-grade security and compliance.", href: "https://descasio.io/press/descasio-launches-africas-first-sovereign-ai-cloud/" },
  { date: "December 2025", title: "Descasio Celebrates 15 Years of Technology Leadership in Nigeria", body: "From cloud pioneers in 2010 to Sovereign AI Cloud in 2025, a look back at 15 years of building Africa's digital infrastructure.", href: "https://descasio.io/press/descasio-celebrates-15-years-of-technology-leadership-in-nigeria/" },
  { date: "November 2025", title: "PlugIQ: How a Nigerian No-Code Platform is Automating Enterprise Workflows", body: "Descasio's workflow automation platform reduces approval times by 60% for enterprises across energy, finance, and government.", href: "https://descasio.io/press/plugiq-how-a-nigerian-no-code-platform-is-automating-enterprise-workflows/" },
  { date: "September 2025", title: "Descasio CEO Dele Nedd on AI as National Infrastructure", body: "Speaking at the Enterprise Collaboration Forum on why Africa needs sovereign AI infrastructure, not just imported solutions.", href: "https://descasio.io/press/descasio-ceo-dele-nedd-on-ai-as-national-infrastructure/" },
  { date: "July 2025", title: "Descasio Empowers Young Girls in Lagos with Data Skills for the Future", body: "A 6-week in-person data analysis training programme for young girls in Lagos, in partnership with HOH Training Facility. Featured in TechCabal.", href: "https://techcabal.com/2025/07/29/descasio-empowers-young-girls-in-lagos-with-data-skills-for-the-future/" },
  { date: "Coverage", title: "Descasio Celebrates Women in Leadership", body: "Descasio's Executive Brunch celebrating Women in Leadership gained strong media coverage across leading news and tech platforms.", href: "https://descasio.io/press/descasio-celebrates-women-in-leadership/" },
];

export default function Press() {
  return (
    <>
      <PageHero
        label="Press"
        title={<>Descasio <span className="text-accent-strong dark:text-accent">in the news.</span></>}
        intro="Awards, media coverage, and press releases."
      />
      <section className="mx-auto grid max-w-6xl gap-10 px-4 py-8 lg:grid-cols-[1.3fr_0.7fr]">
        <ol className="relative border-l-2 border-line pl-8">
          {items.map((it, i) => (
            <Reveal key={it.title} delay={i * 0.04} className="pb-10 last:pb-0">
              <li className="relative">
                <span aria-hidden className="absolute -left-[41px] top-1.5 size-4 rounded-full border-4 border-[var(--bg)] bg-accent" />
                <p className="text-sm font-bold text-accent-strong dark:text-accent">{it.date}</p>
                <a href={it.href} target="_blank" rel="noopener noreferrer" className="group mt-2 inline-flex items-start gap-2 text-xl font-bold leading-snug text-fg">
                  {it.title}
                  <ArrowUpRight size={18} weight="bold" className="mt-1 shrink-0 transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5" />
                </a>
                <p className="mt-2 max-w-xl leading-relaxed text-muted">{it.body}</p>
              </li>
            </Reveal>
          ))}
        </ol>
        <aside className="lg:sticky lg:top-28 lg:self-start">
          <div className="glass rounded-[var(--radius-card)] p-7">
            <h2 className="text-lg font-bold text-fg">Media inquiries</h2>
            <p className="mt-2 leading-relaxed text-muted">For press inquiries, interviews, or speaking requests, contact</p>
            <a href="mailto:marketing@descasio.io" className="mt-3 inline-block font-semibold text-accent-strong dark:text-accent">marketing@descasio.io</a>
          </div>
        </aside>
      </section>
    </>
  );
}
