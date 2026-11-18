import type { MetadataRoute } from "next";
import { services } from "@/content/services";

const base = process.env.NEXT_PUBLIC_SITE_URL ?? "https://descasio.io";
const pages = ["", "solutions", "plugiq", "about", "partners", "careers", "contact", "case-studies", "blog", "whitepapers", "events", "press", "ai-readiness", "privacy-policy"];

export default function sitemap(): MetadataRoute.Sitemap {
  return [...pages, ...services.map((s) => s.slug)].map((p) => ({
    url: `${base}/${p ? `${p}/` : ""}`,
    changeFrequency: "monthly",
    priority: p === "" ? 1 : 0.7,
  }));
}
