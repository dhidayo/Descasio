import type { Metadata } from "next";
import { BookOpenText, DownloadSimple } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";

export const metadata: Metadata = { title: "Whitepapers & Guides", description: "In-depth resources on cloud, AI, and enterprise technology. Download free." };

// TODO(cms): source from the WordPress whitepaper type; downloads currently use the live gated pages.
const papers = [
  { title: "The Enterprise Playbook for Becoming AI-Ready", body: "Who really owns your AI? A new report reveals why Nigeria's next competitive advantage won't come from where your data sits alone.", href: "https://descasio.io/whitepapers/the-enterprise-playbook-for-becoming-ai-ready/" },
  { title: "Beyond The Cloud: The Sovereign AI Playbook for Nigerian Enterprises 2026", body: "Is your organisation building AI on borrowed foundations? As Nigerian enterprises race to adopt AI, a critical question is emerging.", href: "https://descasio.io/whitepapers/beyond-the-cloud-the-sovereign-ai-playbook-for-nigerian-enterprises-2026/" },
  { title: "How Enterprises Cut Approval Time by 60%", body: "Real-world examples of how PlugIQ transforms manual approval workflows into automated, auditable processes.", href: "https://descasio.io/whitepapers/how-enterprises-cut-approval-time-by-60/" },
  { title: "AI Readiness Assessment Framework", body: "A structured self-assessment to evaluate your data maturity, infrastructure, security posture, and organisational readiness for AI.", href: "https://descasio.io/whitepapers/ai-readiness-assessment-framework/" },
  { title: "The CIO's Guide to Sovereign Cloud in Nigeria", body: "Everything you need to know about data sovereignty, NDPR compliance, and building AI-ready infrastructure in-country.", href: "https://descasio.io/whitepapers/the-cios-guide-to-sovereign-cloud-in-nigeria/" },
];

export default function Whitepapers() {
  const [lead, ...rest] = papers;
  return (
    <>
      <PageHero label="Resources" title={<>Whitepapers <span className="text-accent-strong dark:text-accent">& guides.</span></>} intro="In-depth resources on cloud, AI, and enterprise technology. Download free." />
      <section className="mx-auto max-w-6xl px-4 py-8">
        <Reveal>
          <a href={lead.href} target="_blank" rel="noopener noreferrer" className="group relative grid overflow-hidden rounded-[28px] bg-accent-strong p-8 text-white md:grid-cols-[1fr_auto] md:items-end md:p-12">
            <div>
              <BookOpenText size={36} weight="duotone" />
              <h2 className="mt-6 max-w-2xl text-3xl font-extrabold leading-tight tracking-tight md:text-4xl">{lead.title}</h2>
              <p className="mt-3 max-w-xl leading-relaxed text-white/85">{lead.body}</p>
            </div>
            <span className="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 font-semibold text-accent-strong md:mt-0">
              <DownloadSimple size={18} weight="bold" /> Download Free
            </span>
          </a>
        </Reveal>
        <div className="mt-5 grid gap-5 sm:grid-cols-2">
          {rest.map((p, i) => (
            <Reveal key={p.title} delay={(i % 2) * 0.07}>
              <a href={p.href} target="_blank" rel="noopener noreferrer" className="glass group flex h-full flex-col justify-between rounded-[var(--radius-card)] p-7 transition-transform duration-500 hover:-translate-y-1">
                <div>
                  <BookOpenText size={28} weight="duotone" className="text-accent" />
                  <h2 className="mt-5 text-xl font-bold leading-snug text-fg">{p.title}</h2>
                  <p className="mt-2 leading-relaxed text-muted">{p.body}</p>
                </div>
                <span className="mt-6 inline-flex items-center gap-2 font-semibold text-accent-strong dark:text-accent">
                  <DownloadSimple size={17} weight="bold" /> Download Free
                </span>
              </a>
            </Reveal>
          ))}
        </div>
      </section>
    </>
  );
}
