// Builds descasio-elements/data/pages.json: every page of the site, composed from Descasio elements,
// using the same copy as the Next.js site (src/content/*). Run from wordpress/:
//   node --experimental-strip-types build/export-pages.mjs
import { writeFileSync, readFileSync } from "node:fs";

const site = await import("../../src/content/site.ts");
const { services } = await import("../../src/content/services.ts");
const dip = await import("../../src/content/dip.ts");

const booking = site.company.booking;
const lines = (a) => a.join("\n");
const assetOf = (src) => "asset:" + src.replace(/^\//, ""); // "/team/x.png" -> "asset:team/x.png"
const cta = (title, text, label = "Book a Strategy Session", url = booking) => ({ type: "cta_band", settings: { title, text, label, url } });
const notSure = cta("Not sure where to start?", "Our team will help you identify the highest-impact opportunity and build a phased roadmap.");

const pages = [];

/* Home: element defaults are the home page copy. */
pages.push({
  slug: "home",
  title: "Home",
  front: true,
  elements: ["hero", "stats", "dip_feature", "logo_marquee", "layers", "bento", "results", "cta_band"].map((type) => ({ type, settings: {} })),
});

/* Decision Intelligence Platform */
pages.push({
  slug: "decision-intelligence-platform",
  title: "Decision Intelligence Platform",
  elements: [
    { type: "split_hero", settings: {} },
    { type: "icon_cards", settings: {} },
    { type: "accent_panel", settings: {} },
    { type: "steps", settings: {} },
    { type: "tabs", settings: {} },
    { type: "score_panel", settings: {} },
    { type: "founding_circle", settings: {} },
    cta("Make your next big decision with data you can defend.", "Experience DIP through a Proof of Concept with no initial commitment. Explore its capabilities and identify practical use cases for your organisation.", "Request Your Assessment", "/contact/?topic=dip"),
  ],
});

/* Solutions */
pages.push({
  slug: "solutions",
  title: "Solutions",
  elements: [
    { type: "page_hero", settings: { label: "Solutions", title: "Technology built to transform how African enterprises operate, scale, and win.", intro: "Decision intelligence, infrastructure, automation, and advisory. One partner, from your data foundation to the decisions it supports.", btn_label: "Book a Strategy Session", btn_url: booking } },
    {
      type: "feature_rows",
      settings: {
        numbered: "yes",
        items: [
          { icon: "chart-line-up", label: "Decision Intelligence", status: "Flagship", title: "Decision Intelligence Platform (DIP)", text: "Turn fragmented data into decisions you can trust. DIP connects, governs, and monitors your critical data so every report, insight, and AI initiative is built on accuracy, traceability, and control.", badges: "", btn_label: "Explore DIP", btn_url: "/decision-intelligence-platform/", list_title: "", list: lines(["Connects to your existing systems without disruption", "Automated quality checks before data reaches reporting", "Complete lineage from source to insight", "Governed, AI-ready data leaders can act on"]) },
          { icon: "cloud-arrow-up", label: "Infrastructure", status: "Coming soon", title: "Sovereign AI Cloud & Modern Infrastructure", text: "Run critical systems with full data sovereignty. Our in-country cloud is built for AI workloads, regulatory compliance, and enterprise-grade resilience.", badges: "", btn_label: "Talk to an Infrastructure Expert", btn_url: "/sovereign-cloud/", list_title: "", list: lines(["In-country data residency compliant with NDPR", "GPU-enabled environments for AI/ML workloads", "Hybrid connectivity to AWS and Azure", "Enterprise-grade SLA with 99.9% uptime"]) },
          { icon: "flow-arrow", label: "Automation", status: "", title: "PlugIQ: Intelligent Workflow Automation", text: "Turn manual approvals, requisitions, and operations into automated, auditable workflows.", badges: "", btn_label: "See PlugIQ in Action", btn_url: "/plugiq/", list_title: "", list: lines(["No-code: describe your process, PlugIQ builds it", "Multi-level approvals with full audit trail", "Connects to ERPs, CRMs, HRMS", "60% faster approval times on average"]) },
          { icon: "brain", label: "Advisory", status: "", title: "AI Transformation Advisory", text: "We design execution-ready roadmaps that take AI initiatives from concept to production.", badges: "", btn_label: "Explore Advisory", btn_url: "/ai-advisory/", list_title: "", list: lines(["AI readiness assessments", "Business-aligned AI strategy", "Operating model redesign", "Responsible AI governance"]) },
        ],
      },
    },
    notSure,
  ],
});

/* Service pages */
for (const s of services) {
  pages.push({
    slug: s.slug,
    title: s.title,
    elements: [
      { type: "page_hero", settings: { label: s.category, status: s.status ?? "", title: s.title, intro: s.intro, btn_label: s.cta, btn_url: booking } },
      {
        type: "service_detail",
        settings: {
          blocks: s.blocks.map((b) => (Array.isArray(b.body) ? { title: b.title, text: "", list: lines(b.body) } : { title: b.title, text: b.body, list: "" })),
          lists: s.lists.map((l) => ({ title: l.title, items: lines(l.items) })),
          promo: s.assessment ? "yes" : "",
        },
      },
      notSure,
    ],
  });
}

/* PlugIQ */
pages.push({
  slug: "plugiq",
  title: "PlugIQ",
  elements: [
    { type: "page_hero", settings: { label: "A Descasio product", title: "The AI layer for {approval workflows}", intro: "PlugIQ automates enterprise approvals, requisitions, and compliance workflows. Describe your process in plain language. PlugIQ builds it, runs it, audits every action.", btn_label: "Request a Demo", btn_url: "/contact/?topic=plugiq" } },
    {
      type: "steps",
      settings: {
        style: "cards",
        title: "",
        text: "",
        items: [
          { icon: "target", title: "Define your goal", text: "“I want purchase approvals completed within 24 hours with full audit trail.”" },
          { icon: "magic-wand", title: "PlugIQ builds the workflow", text: "AI designs the routing, approver logic, escalation rules, and notifications automatically." },
          { icon: "plugs-connected", title: "Connect your systems", text: "Plug into your ERP, HRMS, CRM, or collaboration tools. No custom development required." },
          { icon: "chart-line-up", title: "Monitor and optimise", text: "Real-time dashboards show bottlenecks, approval times, and compliance status." },
        ],
      },
    },
    { type: "use_cases", settings: {} },
    cta("See PlugIQ in action.", "15-minute demo. We'll show you exactly how PlugIQ would automate your most painful workflow.", "Request a Demo", "/contact/?topic=plugiq"),
  ],
});

/* About */
pages.push({
  slug: "about",
  title: "About Us",
  elements: [
    { type: "page_hero", settings: { label: "About Descasio", title: "15 years of building {Africa's digital infrastructure.}", intro: "Founded in 2010 by Dele Nedd and Femi Olugbesan, Descasio pioneered cloud adoption in Nigeria when most businesses had never heard the word. Today we serve 400+ organisations across energy, finance, retail, and the public sector." } },
    { type: "values", settings: { items: site.values.map((v) => ({ title: v.title, text: v.body })) } },
    { type: "people", settings: { title: "The team behind Descasio.", style: "cards", items: site.leadership.map((p) => ({ name: p.name, role: p.role, photo: assetOf(p.img) })) } },
    { type: "people", settings: { title: "Board of Directors", style: "circles", items: site.board.map((p) => ({ name: p.name, role: p.role, photo: assetOf(p.img) })) } },
    cta("Want to join the team?", "We're always looking for sharp engineers, consultants, and operators who want to build Africa's digital infrastructure.", "View Open Roles", "/careers/"),
  ],
});

/* Partners */
pages.push({
  slug: "partners",
  title: "Partners",
  elements: [
    { type: "page_hero", settings: { label: "Partners", title: "Global partnerships. {Local delivery.}", intro: "We partner with the world's leading technology companies to deliver enterprise-grade solutions with deep African market expertise.", pills: lines(site.alliances) } },
    {
      type: "feature_rows",
      settings: {
        numbered: "",
        items: site.partners.map((p) => ({ icon: "", label: p.area, status: "", title: `Descasio + ${p.name}`, text: p.body, badges: lines(p.badges), btn_label: "", btn_url: "", list_title: p.name === "Security Partners" ? "Security stack" : "Joint capabilities", list: lines(p.capabilities) })),
      },
    },
    cta("Ready to stop stitching together vendors?", "Book a 30-minute strategy session with our team. No pitch deck, no pressure. Just an honest conversation about where your technology needs to go next."),
  ],
});

/* Careers */
pages.push({
  slug: "careers",
  title: "Careers",
  elements: [
    { type: "page_hero", settings: { label: "Careers", title: "Build Africa's digital infrastructure {with us.}", intro: "We're a team of 60+ engineers, consultants, and operators who believe technology should work for Africa, not just in Africa." } },
    { type: "jobs", settings: { apply_email: site.company.email, items: site.roles.map((r) => ({ title: r.title, team: r.team, location: r.location, type: "Full-time", url: "" })) } },
    cta("Don't see your role?", "We're always looking for exceptional people. Send us your CV and tell us what you'd build.", "Send Your CV", `mailto:${site.company.email}?subject=CV%20submission`),
  ],
});

/* Case studies */
pages.push({
  slug: "case-studies",
  title: "Case Studies",
  elements: [
    { type: "page_hero", settings: { label: "Case studies", title: "Real impact. {Real results.}", intro: "See how we've helped enterprises across energy, finance, logistics, and government modernise operations and accelerate growth." } },
    {
      type: "case_studies",
      settings: {
        items: site.caseStudies.map((c) => ({ sector: c.sector, title: c.title, text: c.summary, m1_value: c.metrics[0]?.value ?? "", m1_label: c.metrics[0]?.label ?? "", m2_value: c.metrics[1]?.value ?? "", m2_label: c.metrics[1]?.label ?? "", url: c.href ?? "" })),
      },
    },
    cta("Ready to stop stitching together vendors?", "Book a 30-minute strategy session with our team. No pitch deck, no pressure. Just an honest conversation about where your technology needs to go next."),
  ],
});

/* Contact */
pages.push({
  slug: "contact",
  title: "Contact",
  elements: [
    { type: "page_hero", settings: { label: "Get in touch", title: "Let's talk about what {you're building.}", intro: "Book a strategy session or tell us about your project. No pitch deck. No pressure. Just a real conversation." } },
    { type: "contact", settings: {} },
  ],
});

/* AI Readiness */
pages.push({
  slug: "ai-readiness",
  title: "AI Readiness Assessment",
  elements: [
    { type: "page_hero", settings: { label: "Free assessment", title: "How ready is your organisation for {AI?}", intro: "Answer 12 questions across 4 dimensions. Get your score and a personalised breakdown in under 5 minutes." } },
    { type: "assessment", settings: {} },
  ],
});

/* Whitepapers (copy from src/app/whitepapers/page.tsx) */
const wp = "https://descasio.io/whitepapers/";
pages.push({
  slug: "whitepapers",
  title: "Whitepapers & Guides",
  elements: [
    { type: "page_hero", settings: { label: "Resources", title: "Whitepapers {& guides.}", intro: "In-depth resources on cloud, AI, and enterprise technology. Download free." } },
    {
      type: "downloads",
      settings: {
        items: [
          { title: "The Enterprise Playbook for Becoming AI-Ready", text: "Who really owns your AI? A new report reveals why Nigeria's next competitive advantage won't come from where your data sits alone.", url: wp + "the-enterprise-playbook-for-becoming-ai-ready/" },
          { title: "Beyond The Cloud: The Sovereign AI Playbook for Nigerian Enterprises 2026", text: "Is your organisation building AI on borrowed foundations? As Nigerian enterprises race to adopt AI, a critical question is emerging.", url: wp + "beyond-the-cloud-the-sovereign-ai-playbook-for-nigerian-enterprises-2026/" },
          { title: "How Enterprises Cut Approval Time by 60%", text: "Real-world examples of how PlugIQ transforms manual approval workflows into automated, auditable processes.", url: wp + "how-enterprises-cut-approval-time-by-60/" },
          { title: "AI Readiness Assessment Framework", text: "A structured self-assessment to evaluate your data maturity, infrastructure, security posture, and organisational readiness for AI.", url: wp + "ai-readiness-assessment-framework/" },
          { title: "The CIO's Guide to Sovereign Cloud in Nigeria", text: "Everything you need to know about data sovereignty, NDPR compliance, and building AI-ready infrastructure in-country.", url: wp + "the-cios-guide-to-sovereign-cloud-in-nigeria/" },
        ],
      },
    },
  ],
});

/* Events */
pages.push({
  slug: "events",
  title: "Events",
  elements: [
    { type: "page_hero", settings: { label: "Events", title: "Where we'll be {next.}", intro: "Conferences, panels, webinars, and meetups. Come talk cloud, AI, and enterprise technology with us." } },
    { type: "event_card", settings: { title: dip.launchEvent.name, text: dip.launchEvent.detail } },
  ],
});

/* Press (copy from src/app/press/page.tsx) */
const pr = "https://descasio.io/press/";
pages.push({
  slug: "press",
  title: "Press",
  elements: [
    { type: "page_hero", settings: { label: "Press", title: "Descasio {in the news.}", intro: "Awards, media coverage, and press releases." } },
    {
      type: "press",
      settings: {
        items: [
          { date: "February 2026", title: "Descasio Launches Africa's First Sovereign AI Cloud", text: "Enabling Nigerian enterprises to run AI workloads entirely in-country with enterprise-grade security and compliance.", url: pr + "descasio-launches-africas-first-sovereign-ai-cloud/" },
          { date: "December 2025", title: "Descasio Celebrates 15 Years of Technology Leadership in Nigeria", text: "From cloud pioneers in 2010 to Sovereign AI Cloud in 2025, a look back at 15 years of building Africa's digital infrastructure.", url: pr + "descasio-celebrates-15-years-of-technology-leadership-in-nigeria/" },
          { date: "November 2025", title: "PlugIQ: How a Nigerian No-Code Platform is Automating Enterprise Workflows", text: "Descasio's workflow automation platform reduces approval times by 60% for enterprises across energy, finance, and government.", url: pr + "plugiq-how-a-nigerian-no-code-platform-is-automating-enterprise-workflows/" },
          { date: "September 2025", title: "Descasio CEO Dele Nedd on AI as National Infrastructure", text: "Speaking at the Enterprise Collaboration Forum on why Africa needs sovereign AI infrastructure, not just imported solutions.", url: pr + "descasio-ceo-dele-nedd-on-ai-as-national-infrastructure/" },
          { date: "July 2025", title: "Descasio Empowers Young Girls in Lagos with Data Skills for the Future", text: "A 6-week in-person data analysis training programme for young girls in Lagos, in partnership with HOH Training Facility. Featured in TechCabal.", url: "https://techcabal.com/2025/07/29/descasio-empowers-young-girls-in-lagos-with-data-skills-for-the-future/" },
          { date: "Coverage", title: "Descasio Celebrates Women in Leadership", text: "Descasio's Executive Brunch celebrating Women in Leadership gained strong media coverage across leading news and tech platforms.", url: pr + "descasio-celebrates-women-in-leadership/" },
        ],
      },
    },
  ],
});

/* Privacy policy: legal text verbatim, as an ordinary page (article layout). */
const privacy = JSON.parse(readFileSync("../src/content/privacy.json", "utf8"));
const esc = (t) => t.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
pages.push({
  slug: "privacy-policy",
  title: "Privacy Policy",
  excerpt: privacy.meta,
  content: privacy.blocks.map((b) => (b.t === "p" ? `<p>${b.label ? `<strong>${esc(b.label)}</strong> ` : ""}${esc(b.text)}</p>` : `<${b.t}>${esc(b.text)}</${b.t}>`)).join("\n"),
});

/* Blog: the posts page (the theme renders the post list). */
pages.push({ slug: "blog", title: "Blog", posts_page: true, excerpt: "Perspectives from the team building Africa's digital infrastructure.", content: "" });

writeFileSync("descasio-elements/data/pages.json", JSON.stringify(pages, null, 1));
console.log(`${pages.length} pages written`);
