// Service pages rendered by src/app/(services)/[slug]/page.tsx.
// Copy from descasio.io, in British English.

export type Service = {
  slug: string;
  category: "Infrastructure" | "Advisory";
  title: string;
  status?: string;
  intro: string;
  blocks: { title: string; body: string | string[] }[];
  cta: string;
  lists: { title: string; items: string[] }[];
  assessment?: boolean;
};

export const services: Service[] = [
  {
    slug: "sovereign-cloud",
    category: "Infrastructure",
    title: "Sovereign AI Cloud & Modern Enterprise Infrastructure",
    status: "Coming soon",
    intro:
      "Run critical systems entirely in-country with enterprise-grade security, AI-ready compute, and full regulatory compliance.",
    blocks: [
      {
        title: "Why sovereign cloud matters",
        body: "For enterprises operating in regulated industries, data residency is not optional. Nigerian and African regulatory frameworks increasingly require that sensitive data stays within national borders. Our Sovereign AI Cloud enables you to run AI workloads, data platforms, and mission-critical systems entirely in-country, without compromising on performance or global connectivity.",
      },
      {
        title: "Built for AI workloads",
        body: "Modern infrastructure must power intelligence, not just host applications. Our cloud is architected with GPU-enabled environments, data lakes, vector databases, and AI-optimised compute, so your systems are ready for analytics, machine learning, and GenAI at scale.",
      },
      {
        title: "Hybrid without compromise",
        body: "Sovereignty does not mean isolation. We integrate seamlessly with AWS and Microsoft Azure, enabling secure hybrid and multi-cloud architectures. Burst AI workloads to hyperscalers when needed, optimise costs, and retain sovereignty over your most critical data.",
      },
      {
        title: "Security, resilience, continuity",
        body: "Enterprise-grade cybersecurity, infrastructure automation, and disaster recovery are embedded from day one. Not bolted on as afterthoughts.",
      },
      {
        title: "Who this is for",
        body: [
          "Enterprises with regulated or sensitive data requirements",
          "Government and public sector institutions",
          "Financial services, energy, telecoms, and critical infrastructure operators",
          "Organisations preparing for AI adoption at scale",
        ],
      },
    ],
    cta: "Talk to an Infrastructure Expert",
    lists: [
      {
        title: "Technical specifications",
        items: [
          "Tier III+ data centre, Lagos",
          "99.9% uptime SLA",
          "GPU-enabled compute (NVIDIA A100/H100)",
          "NDPR compliant architecture",
          "ISO 27001 aligned controls",
          "Hybrid peering with AWS & Azure",
          "Sub-10ms latency within Lagos",
          "24/7 NOC monitoring",
        ],
      },
      { title: "Certifications & compliance", items: ["NDPR Ready", "ISO 27001", "SOC 2 Aligned", "AWS Partner"] },
    ],
  },
  {
    slug: "cloud-migration",
    category: "Infrastructure",
    title: "Cloud Migration Services",
    intro:
      "Move from legacy infrastructure to modern cloud with zero disruption. We've migrated workloads for 1,000+ organisations across Nigeria and West Africa.",
    blocks: [
      {
        title: "Our approach",
        body: "Every migration starts with a comprehensive assessment: what you're running, where it lives, what it costs, and what's at risk. We then design a phased migration plan that minimises downtime and maximises the value of moving to cloud.",
      },
      {
        title: "What we migrate",
        body: [
          "On-premise servers and data centres to AWS, Azure, or our Sovereign AI Cloud",
          "Legacy applications to cloud-native architectures",
          "Email and collaboration to Microsoft 365 or Google Workspace",
          "Databases to managed cloud services",
          "Disaster recovery to cloud-based DR",
        ],
      },
      {
        title: "Why enterprises choose us",
        body: "We've been migrating Nigerian enterprises to the cloud since before most of our competitors existed. We understand the bandwidth constraints, the regulatory environment, the procurement cycles. We know what works here, not just what works in the textbook.",
      },
    ],
    cta: "Plan Your Migration",
    lists: [
      {
        title: "Migration capabilities",
        items: [
          "AWS Migration Acceleration Programme",
          "Hybrid and multi-cloud architectures",
          "Application modernisation",
          "Database migration & optimisation",
          "Microsoft 365 / Google Workspace",
          "Post-migration managed services",
        ],
      },
      {
        title: "Typical results",
        items: ["25-40% infrastructure cost reduction", "99.9% uptime post-migration", "Zero data loss track record", "8-16 week migration timeline"],
      },
    ],
  },
  {
    slug: "cybersecurity",
    category: "Infrastructure",
    title: "Cybersecurity & Compliance",
    intro:
      "Protect your enterprise with defence-in-depth security powered by Sophos, Fortinet, Checkpoint, and Cisco. From endpoint to cloud, we've got you covered.",
    blocks: [
      {
        title: "Enterprise security stack",
        body: "We design, deploy, and manage multi-layered security architectures tailored to your industry and risk profile. Our partnerships with the world's leading security vendors mean you get best-in-class protection with local expertise and support.",
      },
      {
        title: "Compliance & governance",
        body: "NDPR, ISO 27001, SOC 2, PCI-DSS. We help you meet and maintain compliance requirements through continuous monitoring, policy enforcement, and regular assessments. Our compliance dashboards give your leadership real-time visibility into your security posture.",
      },
      {
        title: "Managed security services",
        body: [
          "24/7 security monitoring and incident response",
          "Vulnerability management and penetration testing",
          "Security awareness training for your teams",
          "Regular security posture reviews and improvement plans",
        ],
      },
    ],
    cta: "Get a Security Assessment",
    lists: [
      { title: "Security partners", items: ["Sophos", "Fortinet", "Checkpoint", "Cisco"] },
      {
        title: "Services include",
        items: [
          "Firewall & network security",
          "Endpoint detection & response",
          "Email security & anti-phishing",
          "SIEM & log management",
          "Vulnerability assessments",
          "Incident response planning",
          "NDPR compliance consulting",
        ],
      },
    ],
  },
  {
    slug: "backup",
    category: "Infrastructure",
    title: "Backup & Disaster Recovery",
    intro:
      "Resilience and continuity, embedded from day one. Not bolted on as an afterthought.",
    blocks: [
      {
        title: "Recovery you can rely on",
        // TODO(content): the live page has no body copy yet. Replace with approved copy.
        body: "Our team designs backup and disaster recovery around your recovery targets, on AWS, Azure, or our Sovereign AI Cloud. Talk to us about protecting your most critical systems.",
      },
    ],
    cta: "Talk to an Infrastructure Expert",
    lists: [],
  },
  {
    slug: "ai-advisory",
    category: "Advisory",
    title: "AI Transformation Advisory",
    intro:
      "We design execution-ready roadmaps that take AI initiatives from concept to production, embedded in how your business actually operates.",
    blocks: [
      {
        title: "From strategy to scale",
        body: "Most AI investments stall after the proof of concept. Strategy decks pile up but nothing reaches production. We fix that with roadmaps that connect technology investments to business outcomes.",
      },
      {
        title: "Our focus areas",
        body: [
          "Business-aligned AI and digital strategy",
          "Operating model and workflow redesign for the AI era",
          "Responsible AI adoption and governance",
          "Enterprise-wide scale and adoption",
        ],
      },
      {
        title: "Intelligence first",
        body: "We align advisory with execution, combining PlugIQ, GenAI, and systems integration to ensure intelligence is operationalised, not isolated in proofs of concept. The goal is production-scale AI that your teams actually use.",
      },
    ],
    cta: "Book a Strategy Session",
    lists: [
      {
        title: "Engagement model",
        items: ["AI Readiness Assessment: 2-3 weeks", "Strategy & Roadmap: 4-6 weeks", "Implementation: 8-16 weeks", "Ongoing advisory: retainer"],
      },
    ],
    assessment: true,
  },
  {
    slug: "ai-competency",
    category: "Advisory",
    title: "AI Competency",
    intro:
      "We help African enterprises turn AI ambition into production results, validated by AWS, built on a governed data foundation.",
    blocks: [
      {
        title: "The problem",
        body: [
          "No clear starting point: too many possible use cases, no way to rank them",
          "Data that isn't ready: fragmented, ungoverned, or unsafe to feed an AI model",
          "Unresolved risk questions: where data lives, who can access it, whether it survives an audit",
          "No path to production: a proof of concept that impressed a room but was never engineered to run at scale",
        ],
      },
      {
        title: "AWS-validated. Built for Africa.",
        body: [
          "We've done this before: 15+ years running production systems for 450+ organisations across Africa's most regulated sectors",
          "We build on validated architecture: AWS's own reference patterns for generative and agentic AI, not improvised tooling",
          "We take security seriously from day one: data residency, access, and compliance worked out with your CTO/CISO before anything goes live",
        ],
      },
      {
        title: "Choose your starting point",
        body: [
          "Get AI-Ready: the AI Decision Sprint (10 working days) ranks your use cases and resolves data and control gaps",
          "Prove AI Value: a Proof of Value (4-6 weeks) tests the AI solution against your real workflow and baseline",
          "Build Your Data Foundation: a Data Foundation Assessment (3-4 weeks) maps your data landscape and gives you a remediation plan",
        ],
      },
    ],
    cta: "Request an AI Decision Sprint",
    lists: [
      {
        title: "Engagement model",
        items: ["AI Decision Sprint: 10 working days", "Proof of Value: 4-6 weeks", "Data Foundation Assessment: 3-4 weeks", "Ongoing advisory: retainer"],
      },
    ],
    assessment: true,
  },
  {
    slug: "cost-optimization",
    category: "Advisory",
    title: "Cloud Cost Optimisation",
    intro:
      "Most enterprises overspend on cloud by 25-40%. We identify waste, right-size resources, and implement governance so your cloud bill matches your actual usage.",
    blocks: [
      {
        title: "Where the waste hides",
        body: "Oversized instances running at 10% utilisation. Orphaned storage volumes nobody remembers provisioning. Development environments running 24/7 when they're used 8 hours a day. Reserved instances that don't match actual usage patterns. We find all of it.",
      },
      {
        title: "Our approach",
        body: "We start with a full audit of your cloud estate: compute, storage, networking, and licensing. We then implement right-sizing, scheduling, reserved capacity planning, and cost governance dashboards that give your finance team real-time visibility into cloud spend.",
      },
      {
        title: "Governance that sticks",
        body: "Optimisation is not a one-time exercise. We implement cloud cost governance frameworks, tagging policies, budget alerts, and automated shutdown schedules so savings compound over time rather than eroding as the organisation grows.",
      },
    ],
    cta: "Get a Cost Audit",
    lists: [
      {
        title: "Typical savings",
        items: ["25-40% reduction in monthly cloud spend", "ROI within the first 30 days", "Real-time cost dashboards", "Automated cost governance"],
      },
      { title: "Platforms covered", items: ["AWS", "Azure", "Google Cloud", "Sovereign Cloud"] },
    ],
  },
];

export const getService = (slug: string) => services.find((s) => s.slug === slug);
