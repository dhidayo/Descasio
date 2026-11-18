import Link from "next/link";
import { company } from "@/content/site";
import { Logo } from "@/components/ui/Logo";

const columns = [
  {
    title: "Solutions",
    links: [
      ["Sovereign AI Cloud", "/sovereign-cloud"],
      ["Cloud Migration", "/cloud-migration"],
      ["Cybersecurity & Compliance", "/cybersecurity"],
      ["Backup & Disaster Recovery", "/backup"],
      ["PlugIQ", "/plugiq"],
      ["AI Advisory", "/ai-advisory"],
      ["Cloud Cost Optimisation", "/cost-optimization"],
      ["AI Competency", "/ai-competency"],
    ],
  },
  {
    title: "Company",
    links: [
      ["About Us", "/about"],
      ["Partners", "/partners"],
      ["Careers", "/careers"],
      ["Press", "/press"],
      ["Contact", "/contact"],
    ],
  },
  {
    title: "Resources",
    links: [
      ["Blog", "/blog"],
      ["Case Studies", "/case-studies"],
      ["Whitepapers & Guides", "/whitepapers"],
      ["Events", "/events"],
      ["AI Readiness Assessment", "/ai-readiness"],
      ["Privacy Policy", "/privacy-policy"],
    ],
  },
];

export function Footer() {
  return (
    <footer className="px-4 pb-6 pt-24">
      <div className="glass mx-auto max-w-6xl rounded-[28px] p-8 md:p-12">
        <div className="grid gap-12 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
          <div>
            <Logo className="h-8 w-auto" />
            <p className="mt-5 max-w-xs leading-relaxed text-muted">
              {company.tagline} {company.summary}
            </p>
            <address className="mt-6 space-y-1.5 text-[15px] not-italic">
              <a href={`mailto:${company.email}`} className="block font-semibold text-fg hover:text-accent-strong dark:hover:text-accent">
                {company.email}
              </a>
              <a href={company.phoneHref} className="block text-muted hover:text-fg">
                {company.phone}
              </a>
              <span className="block text-muted">{company.address}</span>
            </address>
          </div>
          {columns.map((c) => (
            <div key={c.title}>
              <h3 className="text-sm font-bold text-fg">{c.title}</h3>
              <ul className="mt-4 space-y-2.5">
                {c.links.map(([label, href]) => (
                  <li key={href}>
                    <Link href={href} className="text-[15px] text-muted transition-colors hover:text-fg">
                      {label}
                    </Link>
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
        <div className="mt-12 border-t border-line pt-6 text-sm text-muted">
          © {new Date().getFullYear()} {company.legal}. All rights reserved.
        </div>
      </div>
    </footer>
  );
}
