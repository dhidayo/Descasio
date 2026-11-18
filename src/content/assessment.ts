// AI Readiness Assessment: 12 questions across 4 dimensions, from the live descasio.io assessment.
// Scoring matches the original: each dimension is out of 25, total out of 100.

export const dimensions = ["Data Maturity", "Infrastructure", "Security & Governance", "Organisational Readiness"] as const;

export type Question = { dim: number; q: string; context: string; options: { text: string; score: number }[] };

export const questions: Question[] = [
  {
    "dim": 0,
    "q": "How would you describe your organisation's data infrastructure?",
    "context": "Think about databases, data warehouses, and how data flows between systems.",
    "options": [
      {
        "text": "Mostly spreadsheets and siloed databases with manual data movement",
        "score": 1
      },
      {
        "text": "Centralised databases exist but data quality is inconsistent",
        "score": 2
      },
      {
        "text": "Structured data warehouse or lake with defined pipelines",
        "score": 3
      },
      {
        "text": "Modern data platform with automated quality checks and governance",
        "score": 4
      }
    ]
  },
  {
    "dim": 0,
    "q": "How accessible is your data to the people and systems that need it?",
    "context": "Consider how long it takes to get data for a business decision.",
    "options": [
      {
        "text": "Getting data requires IT requests that take days or weeks",
        "score": 1
      },
      {
        "text": "Some self-service access but most teams still depend on IT",
        "score": 2
      },
      {
        "text": "Most teams can access the data they need with defined permissions",
        "score": 3
      },
      {
        "text": "Real-time access with role-based controls and self-service analytics",
        "score": 4
      }
    ]
  },
  {
    "dim": 0,
    "q": "Do you have formal data governance policies in place?",
    "context": "Data ownership, quality standards, retention policies, and documentation.",
    "options": [
      {
        "text": "No formal governance. Data ownership is unclear.",
        "score": 1
      },
      {
        "text": "Some policies exist but enforcement is inconsistent",
        "score": 2
      },
      {
        "text": "Defined governance with assigned data owners and regular audits",
        "score": 3
      },
      {
        "text": "Mature governance framework with automated enforcement and lineage tracking",
        "score": 4
      }
    ]
  },
  {
    "dim": 1,
    "q": "Where does your primary compute infrastructure run today?",
    "context": "Consider your main business applications and workloads.",
    "options": [
      {
        "text": "Mostly on-premise servers with limited cloud usage",
        "score": 1
      },
      {
        "text": "Mix of on-premise and cloud, migrating gradually",
        "score": 2
      },
      {
        "text": "Primarily cloud-hosted with some legacy systems remaining",
        "score": 3
      },
      {
        "text": "Cloud-native with containerised workloads and infrastructure as code",
        "score": 4
      }
    ]
  },
  {
    "dim": 1,
    "q": "Could your current infrastructure support AI/ML workloads?",
    "context": "GPU compute, large-scale data processing, model training and serving.",
    "options": [
      {
        "text": "No. We don't have the compute or storage capacity.",
        "score": 1
      },
      {
        "text": "Possibly, but we'd need significant upgrades",
        "score": 2
      },
      {
        "text": "We have cloud resources that could be provisioned for AI workloads",
        "score": 3
      },
      {
        "text": "Yes. We have GPU-enabled environments and scalable compute ready.",
        "score": 4
      }
    ]
  },
  {
    "dim": 1,
    "q": "How do you handle scalability and performance monitoring?",
    "context": "Auto-scaling, observability, capacity planning.",
    "options": [
      {
        "text": "Manual scaling. We react to performance issues after they occur.",
        "score": 1
      },
      {
        "text": "Basic monitoring in place but scaling is still mostly manual",
        "score": 2
      },
      {
        "text": "Automated scaling for key systems with proactive monitoring",
        "score": 3
      },
      {
        "text": "Full observability stack with predictive scaling and SLA tracking",
        "score": 4
      }
    ]
  },
  {
    "dim": 2,
    "q": "How mature is your cybersecurity posture?",
    "context": "Firewalls, endpoint protection, incident response, vulnerability management.",
    "options": [
      {
        "text": "Basic firewall and antivirus only",
        "score": 1
      },
      {
        "text": "Managed security tools in place but no formal incident response plan",
        "score": 2
      },
      {
        "text": "Layered security with SIEM, endpoint detection, and incident response",
        "score": 3
      },
      {
        "text": "Defence-in-depth with 24/7 SOC, regular pen testing, and zero-trust architecture",
        "score": 4
      }
    ]
  },
  {
    "dim": 2,
    "q": "Are you compliant with relevant data protection regulations?",
    "context": "NDPR, ISO 27001, SOC 2, PCI-DSS, or industry-specific requirements.",
    "options": [
      {
        "text": "Not sure what regulations apply to us",
        "score": 1
      },
      {
        "text": "Aware of requirements but not yet compliant",
        "score": 2
      },
      {
        "text": "Compliant with primary regulations. Working on additional certifications.",
        "score": 3
      },
      {
        "text": "Fully compliant with continuous monitoring and automated policy enforcement",
        "score": 4
      }
    ]
  },
  {
    "dim": 2,
    "q": "Do you have an AI governance or responsible AI framework?",
    "context": "Policies for bias, transparency, data usage, model accountability.",
    "options": [
      {
        "text": "Haven't considered this yet",
        "score": 1
      },
      {
        "text": "Aware it's needed but no formal framework",
        "score": 2
      },
      {
        "text": "Draft policies exist or we're currently developing them",
        "score": 3
      },
      {
        "text": "Formal AI governance with review boards, audit trails, and clear accountability",
        "score": 4
      }
    ]
  },
  {
    "dim": 3,
    "q": "Does your leadership team have a clear AI strategy?",
    "context": "Not just enthusiasm. A defined vision with budget, timeline, and success metrics.",
    "options": [
      {
        "text": "No. AI is talked about but there's no strategy.",
        "score": 1
      },
      {
        "text": "Leadership is interested but hasn't committed resources or timeline",
        "score": 2
      },
      {
        "text": "AI strategy exists with budget allocated and executive sponsorship",
        "score": 3
      },
      {
        "text": "AI is embedded in business strategy with KPIs, governance, and cross-functional alignment",
        "score": 4
      }
    ]
  },
  {
    "dim": 3,
    "q": "What AI/ML talent do you have in-house?",
    "context": "Data scientists, ML engineers, analytics engineers, or teams using AI tools.",
    "options": [
      {
        "text": "None. We'd need to hire or outsource everything.",
        "score": 1
      },
      {
        "text": "Some data analysts but no dedicated AI/ML specialists",
        "score": 2
      },
      {
        "text": "Small data science or analytics team with some ML experience",
        "score": 3
      },
      {
        "text": "Established AI/ML team with production deployment experience",
        "score": 4
      }
    ]
  },
  {
    "dim": 3,
    "q": "How does your organisation handle change and new technology adoption?",
    "context": "Think about the last major technology change you implemented.",
    "options": [
      {
        "text": "Change is slow and met with significant resistance",
        "score": 1
      },
      {
        "text": "We adopt new tools but rollout is often incomplete or delayed",
        "score": 2
      },
      {
        "text": "Structured change management with training and adoption tracking",
        "score": 3
      },
      {
        "text": "Culture of continuous improvement. Teams actively seek and adopt new capabilities.",
        "score": 4
      }
    ]
  }
];

/** Recommendation per dimension, by bracket: 0-6, 7-12, 13-18, 19-25. */
export const recommendations: string[][] = [
  [
    "Your data foundation needs significant work before AI can deliver value. Start with a data audit to understand what you have, where it lives, and who owns it.",
    "You have some data infrastructure but gaps in quality and accessibility will limit AI outcomes. Focus on consolidating data sources and establishing governance.",
    "Solid data foundation. Focus on automating data quality checks and building the pipelines needed for AI model training and inference.",
    "Strong data maturity. You are well-positioned to support advanced AI workloads. Consider real-time data streaming for production ML."
  ],
  [
    "Your infrastructure needs modernisation before supporting AI workloads. A cloud migration strategy should be your first priority.",
    "You are on the path to cloud but need to accelerate. Prioritise migrating remaining legacy systems and provisioning AI-ready compute.",
    "Good infrastructure base. Focus on GPU-enabled environments and automated scaling to support AI/ML workloads in production.",
    "Excellent infrastructure readiness. You have the foundation for production-scale AI. Focus on optimisation and cost governance."
  ],
  [
    "Security gaps need to be addressed before introducing AI. Start with a security assessment and compliance roadmap.",
    "You have basics in place but need a more comprehensive security stack and formal compliance program before scaling AI.",
    "Strong security posture. Develop a specific AI governance framework to cover model accountability, bias monitoring, and data usage policies.",
    "Mature security and governance. Extend your existing frameworks to cover AI-specific requirements and you are ready to scale."
  ],
  [
    "Organisational readiness is your biggest gap. Leadership alignment and talent strategy need to come before technology investment.",
    "There is interest but not commitment. Build a business case with clear ROI to secure executive sponsorship and budget.",
    "Good organisational alignment. Invest in upskilling your existing team and establish cross-functional AI working groups.",
    "Your organisation is culturally ready for AI at scale. Focus on execution velocity and measuring business impact."
  ]
];

export const verdicts = [
  { min: 80, headline: "AI-ready. Time to execute.", summary: "Your organisation has strong foundations across all dimensions. The focus now is execution speed and scaling AI from pilots to production." },
  { min: 60, headline: "Strong foundation with gaps to close.", summary: "You have the basics in place but specific areas need attention before AI can deliver at scale. A targeted investment plan will get you there." },
  { min: 40, headline: "Building blocks in place. Strategic investment needed.", summary: "Your organisation has started the journey but significant work remains. A phased approach focusing on the weakest dimensions first will deliver the fastest ROI." },
  { min: 0, headline: "Early stage. Start with foundations.", summary: "AI adoption requires foundational investments in data, infrastructure, and organisational capability. The good news: starting from here means you can build it right from day one." },
];

export function score(answers: number[]) {
  const raw = [0, 0, 0, 0];
  answers.forEach((optIndex, i) => {
    if (optIndex >= 0) raw[questions[i].dim] += questions[i].options[optIndex].score;
  });
  const dims = raw.map((s) => Math.round((s / 12) * 25));
  const total = Math.round(raw.reduce((t, s) => t + (s / 12) * 25, 0));
  const verdict = verdicts.find((v) => total >= v.min)!;
  const recs = dims.map((d, i) => recommendations[i][d <= 6 ? 0 : d <= 12 ? 1 : d <= 18 ? 2 : 3]);
  return { total, dims, verdict, recs };
}
