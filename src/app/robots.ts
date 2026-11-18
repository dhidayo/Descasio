import type { MetadataRoute } from "next";

// Search engines are blocked unless ALLOW_INDEXING=true, so preview links never compete with descasio.io in search.
export default function robots(): MetadataRoute.Robots {
  const base = process.env.NEXT_PUBLIC_SITE_URL ?? "https://descasio.io";
  if (process.env.ALLOW_INDEXING !== "true") return { rules: [{ userAgent: "*", disallow: "/" }] };
  return { rules: [{ userAgent: "*", allow: "/" }], sitemap: `${base}/sitemap.xml` };
}
