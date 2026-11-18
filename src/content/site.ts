// Single source of truth for site copy. Content is taken from descasio.io,
// converted to British English. Route slugs are kept identical to the live site for SEO.

export const company = {
  name: "Descasio",
  legal: "Descasio Technology",
  tagline: "Africa's Intelligent Enterprise Platform.",
  summary:
    "We build the cloud, automate the workflows, and transform the enterprise.",
  email: "hi@descasio.io",
  phone: "+234-1-912-5048",
  phoneHref: "tel:+23419125048",
  address: "3/5 Boyle Street, Lagos Island, Lagos, Nigeria",
  booking: "https://calendly.com/hi-descasio",
};

export const ctas = {
  primary: { label: "Book a Strategy Session", href: company.booking },
  solutions: { label: "Explore Solutions", href: "/solutions" },
};

export type NavLink = { label: string; href: string; description?: string };
export type NavGroup = { label: string; groups: { title: string; links: NavLink[] }[] };

export const nav: (NavLink | NavGroup)[] = [
  { label: "Home", href: "/" },
  {
    label: "Solutions",
    groups: [
      {
        title: "Infrastructure",
        links: [
          { label: "Sovereign AI Cloud", href: "/sovereign-cloud", description: "In-country, AI-ready compute" },
          { label: "Cloud Migration", href: "/cloud-migration", description: "Move to cloud with zero disruption" },
          { label: "Cybersecurity & Compliance", href: "/cybersecurity", description: "Defence in depth, NDPR ready" },
          { label: "Backup & Disaster Recovery", href: "/backup", description: "Resilience from day one" },
        ],
      },
      {
        title: "Platforms",
        links: [
          { label: "Decision Intelligence Platform", href: "/decision-intelligence-platform", description: "Decisions you can trust" },
          { label: "PlugIQ Workflow Automation", href: "/plugiq", description: "Approvals live in days" },
        ],
      },
      {
        title: "Advisory",
        links: [
          { label: "AI Transformation Advisory", href: "/ai-advisory", description: "From strategy to scale" },
          { label: "AI Readiness Assessment", href: "/ai-readiness", description: "Free 5-minute self-assessment" },
          { label: "AI Competency", href: "/ai-competency", description: "AWS-validated AI delivery" },
          { label: "Cloud Cost Optimisation", href: "/cost-optimization", description: "Cut cloud spend by 25-40%" },
        ],
      },
    ],
  },
  { label: "Decision Intelligence", href: "/decision-intelligence-platform" },
  {
    label: "Resources",
    groups: [
      {
        title: "Resources",
        links: [
          { label: "Blog", href: "/blog" },
          { label: "Whitepapers & Guides", href: "/whitepapers" },
          { label: "Case Studies", href: "/case-studies" },
          { label: "Events", href: "/events" },
          { label: "Press", href: "/press" },
        ],
      },
    ],
  },
  {
    label: "Company",
    groups: [
      {
        title: "Company",
        links: [
          { label: "About Us", href: "/about" },
          { label: "Partners", href: "/partners" },
          { label: "Careers", href: "/careers" },
          { label: "Contact", href: "/contact" },
        ],
      },
    ],
  },
];

export const stats = [
  { value: 100, suffix: "K+", label: "Cloud licences deployed and managed" },
  { value: 60, suffix: "%", label: "Faster approvals with PlugIQ automation" },
  { value: 400, suffix: "+", label: "Organisations transformed across Nigeria" },
  { value: 15, suffix: "", label: "Years building Africa's digital infrastructure" },
];

export const clients = [
  "DANGOTE", "NNPC", "TOTAL-ENERGIES", "FED-MINISTRY-OF-FINANCE", "HILTON", "SANOFI", "HONEYWELL",
  "UNIFIED-PAYMENTS", "KONGA", "WAKANOW", "COSCHARIS", "NCDMB", "NBS", "AVON", "7UP",
].map((id) => ({
  id,
  src: `/clients/${id}.png`,
  alt: id.replace(/-/g, " ").toLowerCase().replace(/\b\w/g, (c) => c.toUpperCase()),
}));

export const layers = [
  {
    n: "01",
    title: "Enterprise Consulting & Managed Services",
    body: "From cloud migration strategy to ongoing infrastructure management. We don't hand you a report and leave. We stay, we run it, we take ownership of outcomes.",
    cta: { label: "Explore Services", href: "/solutions" },
    icon: "briefcase",
  },
  {
    n: "02",
    title: "Cloud Infrastructure & Sovereign AI",
    body: "AWS Advanced Partner managing 100K+ cloud licences. Plus in-country, compliant cloud for organisations that need full data sovereignty and AI-ready compute.",
    cta: { label: "Explore Infrastructure", href: "/sovereign-cloud" },
    icon: "cloud",
  },
  {
    n: "03",
    title: "Our Platforms: DIP and PlugIQ",
    body: "Our Decision Intelligence Platform turns fragmented data into decisions you can trust. PlugIQ turns manual approvals into automated, auditable workflows. Built and owned by us.",
    cta: { label: "Explore DIP", href: "/decision-intelligence-platform" },
    icon: "flow",
  },
] as const;

export const differentiators = [
  {
    title: "We own the infrastructure",
    body: "Our Sovereign AI Cloud means your data stays in-country, compliant, and under your control. We don't just resell hyperscaler capacity.",
    icon: "buildings",
  },
  {
    title: "We build our own platforms",
    body: "DIP and PlugIQ are our products, not white-labelled vendor tools. When something breaks, we fix it. When you need a feature, we build it.",
    icon: "lightning",
  },
  {
    title: "AWS Advanced Partner + global alliances",
    body: "Certified across AWS, Google, IBM, Cisco, Fortinet, Sophos, and Checkpoint. Global standards, local delivery.",
    icon: "handshake",
  },
  {
    title: "15 years, Africa-only focus",
    body: "We know the bandwidth constraints, the regulatory environment, the procurement cycles. We've seen what works here, not what works in theory.",
    icon: "globe",
  },
] as const;

export type CaseStudy = {
  sector: string;
  title: string;
  summary: string;
  metrics: { value: string; label: string }[];
  href?: string;
};

export const caseStudies: CaseStudy[] = [
  {
    sector: "Public Sector",
    title: "Digital transformation for a federal government ministry",
    summary: "Modernised document management, collaboration, and communication infrastructure for a major federal ministry.",
    metrics: [{ value: "5,000+", label: "Users migrated" }, { value: "70%", label: "Process efficiency" }],
    href: "https://descasio.io/case-studies/digital-transformation-for-a-federal-government-ministry/",
  },
  {
    sector: "E-commerce",
    title: "How Shopzone built a scalable e-commerce platform on AWS for peak shopping demand",
    summary: "A cloud-native platform for browsing products, placing orders, and managing accounts, engineered to stay fast at peak demand.",
    metrics: [],
    href: "https://descasio.io/case-studies/blog-how-shopzone-built-a-scalable-e-commerce-platform-on-aws-for-peak-shopping-demand/",
  },
  {
    sector: "Fintech",
    title: "How PayNaira secured its digital payments platform with AWS cloud infrastructure",
    summary: "A cloud-native platform for initiating and tracking digital payment transactions securely.",
    metrics: [],
    href: "https://descasio.io/case-studies/blog-how-paynaira-secured-its-digital-payments-platform-with-aws-cloud-infrastructure/",
  },
  {
    sector: "Hospitality",
    title: "Cloud infrastructure and security for an international hotel brand in Nigeria",
    summary: "Managed cloud migration, email security, and compliance for the Nigerian operations of a global hospitality leader.",
    metrics: [{ value: "100%", label: "Compliance achieved" }, { value: "Zero", label: "Security incidents" }],
  },
  {
    sector: "Logistics / Multi-Location",
    title: "Remote workforce enablement for a West African logistics company",
    summary: "Deployed secure remote access, collaboration tools, and endpoint management across 12 locations in 4 countries.",
    metrics: [{ value: "12", label: "Locations connected" }, { value: "4 weeks", label: "Full deployment" }],
  },
  {
    sector: "Fintech",
    title: "Scalable cloud infrastructure for a high-growth fintech platform",
    summary: "Designed autoscaling architecture and cost-governance dashboards during 3x user growth in 4 months.",
    metrics: [{ value: "25%", label: "Monthly savings" }, { value: "Weekly", label: "Deploy cycles" }],
  },
  {
    sector: "Financial Services",
    title: "Legacy modernisation and real-time analytics for a leading Nigerian bank",
    summary: "Replaced outdated on-premise systems with cloud-native architecture, unlocking real-time reporting and customer insights.",
    metrics: [{ value: "3x", label: "Faster reporting" }, { value: "60%", label: "Infra cost saved" }],
  },
  {
    sector: "Energy / Oil & Gas",
    title: "Cloud migration and digital operations for a major national energy company",
    summary: "Migrated legacy infrastructure to hybrid cloud, enabling real-time operational visibility across distributed sites nationwide.",
    metrics: [{ value: "40%", label: "Cost reduction" }, { value: "99.9%", label: "Uptime achieved" }],
  },
];

export const values = [
  { title: "Customer-Centricity", body: "We solve real problems for real businesses. Not theoretical frameworks. Not proofs of concept that never ship." },
  { title: "Ownership", body: "We act with integrity and take responsibility for outcomes. When something breaks at 2am, we're already on it." },
  { title: "Innovation", body: "We challenge norms and lead with possibility. We built our own cloud and our own automation platform because the alternatives weren't good enough." },
  { title: "Leadership", body: "We drive change, not wait for it. From cloud pioneers in 2010 to Sovereign AI Cloud in 2026." },
  { title: "Value Creation", body: "We prioritise impact and lasting results over noise. Every engagement is measured by what it delivered, not what it promised." },
  { title: "Forward Thinking", body: "Our founding principle. We invest today in the infrastructure and capabilities our clients will need tomorrow." },
];

export const leadership = [
  { name: "Dele Nedd", role: "CEO & Co-Founder", img: "/team/Dele-Nedd.png" },
  { name: "Femi Olugbesan", role: "CIO & Co-Founder", img: "/team/Femi-Olugbesan.png" },
  { name: "Nehita Fashe", role: "Chief Sales Officer", img: "/team/Nehitas-Photo.png" },
];

export const board = [
  { name: "Adedotun Sulaiman", role: "Chairman", img: "/team/descasio-board-chairman-Adedotun-Sulaiman.png" },
  { name: "Olanike Jagun", role: "Director", img: "/team/descasio-board-of-directors-Olanike-Jagun.png" },
  { name: "Muhtar Bakare", role: "Director", img: "/team/descasio-board-of-directors-Muktar-Bakare.png" },
  { name: "Lola Masha", role: "Director", img: "/team/descasio-board-of-directors-Lola-Masha.png" },
  { name: "Frederick Udoaka", role: "Director", img: "/team/descasio-board-of-directors-Frederick-Udoaka.png" },
];

export const roles = [
  { title: "Senior Cloud Architect", team: "Engineering", location: "Lagos" },
  { title: "AI/ML Engineer", team: "Engineering", location: "Lagos / Remote" },
  { title: "DevOps Engineer", team: "Engineering", location: "Lagos" },
  { title: "Technical Consultant", team: "Consulting", location: "Lagos" },
  { title: "Enterprise Account Executive", team: "Sales", location: "Lagos" },
  { title: "Content & Marketing Manager", team: "Marketing", location: "Lagos" },
];

export const partners = [
  {
    area: "Cloud Infrastructure",
    name: "AWS",
    body: "As an AWS Advanced Tier Partner, Descasio brings certified expertise across migration, managed services, security, and AI workloads.",
    badges: ["AWS Advanced Partner", "Migration Competency"],
    capabilities: ["Cloud migration (MAP programme)", "AWS managed services", "AI/ML on AWS (SageMaker, Bedrock)", "Well-Architected reviews", "Cost optimisation"],
  },
  {
    area: "Collaboration",
    name: "Google",
    body: "We deploy and manage Google Workspace for enterprises across Nigeria. From migration to ongoing management of 100,000+ licences.",
    badges: ["Google Partner", "Workspace Specialist"],
    capabilities: ["Google Workspace deployment", "Licence management (100K+)", "Migration from legacy email", "Google Cloud Platform"],
  },
  {
    area: "Security",
    name: "Security Partners",
    body: "We work with Sophos, Fortinet, Checkpoint, and Cisco to deliver multi-layered enterprise security.",
    badges: ["Sophos Partner", "Fortinet Partner", "Checkpoint Partner", "Cisco Partner"],
    capabilities: ["Next-gen firewalls", "Endpoint detection & response", "Email & web security", "SIEM & threat intelligence"],
  },
];

export const alliances = ["AWS", "Google", "IBM", "Cisco", "Sophos", "Fortinet", "Checkpoint"];
