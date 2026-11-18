// Decision Intelligence Platform (DIP): Descasio's flagship product.
// Copy from descasio.io/decision-intelligence-platform and Descasio's DIP outreach, in British English.

export const dip = {
  name: "Decision Intelligence Platform",
  short: "DIP",
  href: "/decision-intelligence-platform/",
  assessmentHref: "/contact/?topic=dip",
  headline: "Turn fragmented data into decisions you can trust.",
  intro:
    "DIP connects, governs, and monitors your critical data so every report, insight, and AI initiative is built on a foundation of accuracy, traceability, and control.",
  assessmentNote:
    "The Decision Intelligence Readiness & Value Assessment is a guided engagement with our team, not a self-serve quiz.",
};

/** The live "evidence trail": every stage of a number's journey is checked. */
export const evidenceTrail = [
  { stage: "Source", state: "Verified" },
  { stage: "Ingestion", state: "Verified" },
  { stage: "Quality check", state: "Verified" },
  { stage: "Lineage", state: "Traced" },
  { stage: "Governance", state: "Enforced" },
  { stage: "Insight", state: "Defensible" },
];

export const outcomes = [
  { title: "Make smarter decisions", body: "Turn complex business data into actionable insights for better strategic decisions.", icon: "target" },
  { title: "Predict business outcomes", body: "Identify emerging trends, patterns, and potential risks before they impact performance.", icon: "trend" },
  { title: "Improve operational efficiency", body: "Uncover bottlenecks, optimise processes, and identify opportunities for cost savings.", icon: "gauge" },
  { title: "Gain a competitive advantage", body: "Make faster, data-driven decisions that drive growth and business performance.", icon: "trophy" },
] as const;

export const problems = [
  {
    title: "Reporting without trust",
    body: "Data moves across multiple systems with little visibility into where it originated, how it changed, or whether it can be verified when it matters most.",
  },
  {
    title: "AI without a foundation",
    body: "AI initiatives struggle to deliver value when the underlying data lacks governance, quality controls, and traceability.",
  },
  {
    title: "Decisions without evidence",
    body: "When executives, auditors, or regulators challenge a number, teams spend valuable time investigating instead of acting.",
  },
];

export const steps = [
  { title: "Connect", body: "Integrates with your existing data sources without disrupting the systems you already rely on.", icon: "plugs" },
  { title: "Validate", body: "Applies automated quality checks to identify gaps, inconsistencies, duplicates, and anomalies before they impact reporting.", icon: "check" },
  { title: "Trace", body: "Tracks every data movement and transformation, creating complete lineage from source to insight.", icon: "path" },
  { title: "Govern", body: "Enforces access controls, retention policies, and audit requirements across your data environment.", icon: "shield" },
  { title: "Deliver", body: "Provides trusted reporting, analytics, and AI-ready data that business and technology leaders can confidently act on.", icon: "chart" },
] as const;

export const industries = [
  {
    name: "Financial Services",
    roles: [
      { role: "Executive Leadership", sees: "Portfolio health, emerging credit risk, branch performance, revenue trends, and where management intervention is needed." },
      { role: "Risk & Credit Teams", sees: "High-risk customer segments, delinquency patterns, early-warning signals, loan and portfolio risk drivers, and collection priorities." },
      { role: "Branch & Field Operations", sees: "Branch and agent performance, customer repayment behaviour, geographic trends, underperforming locations, and actionable intervention opportunities." },
    ],
  },
  {
    name: "FMCG",
    roles: [
      { role: "Executive & Commercial Leadership", sees: "Revenue performance, demand trends, growth opportunities, product and category performance, and market risks." },
      { role: "Sales & Distribution Teams", sees: "Distributor and territory performance, sales trends, channel opportunities, customer behaviour, and underperforming areas." },
      { role: "Supply Chain & Operations", sees: "Demand forecasts, inventory risks, product movement, stock-out patterns, warehouse performance, and supply-demand gaps." },
    ],
  },
];

export const scores = [
  { title: "Data Trust", body: "Evaluate how confidently your organisation can trace, verify, and defend critical reporting and business decisions." },
  { title: "Governance Maturity", body: "Assess how consistently data quality, access controls, retention policies, and governance standards are applied." },
  { title: "AI Readiness", body: "Understand whether your current data foundation can support reliable, explainable, and scalable AI initiatives." },
];

export const foundingCircle = {
  title: "Shape DIP as one of a limited number of founding customers.",
  body: "We're onboarding a limited number of foundation customers directly with the product and delivery team, in exchange for reference rights and use-case feedback.",
  perks: [
    "Preferred founding pricing",
    "Direct influence over the product roadmap",
    "Quarterly executive review with the DIP team",
    "Co-branded success story once live",
  ],
  href: "/contact/?topic=dip",
};

export const launchEvent = {
  name: "The Trust Layer",
  description: "Descasio's flagship DIP launch event in Lagos.",
  detail: "Executive roundtable for Financial Services and FMCG leaders. Date to be confirmed.",
  href: "/contact/?topic=dip",
};
