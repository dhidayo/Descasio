// Headless WordPress: descasio.io stays the CMS for posts; this site renders them.
// Responses are cached and refreshed hourly (ISR). Failures degrade to empty results.

const API = process.env.WORDPRESS_API_URL ?? "https://descasio.io/wp-json/wp/v2";
const REVALIDATE = 3600;

type WPRendered = { rendered: string };
type WPPostRaw = {
  id: number;
  slug: string;
  date: string;
  title: WPRendered;
  excerpt: WPRendered;
  content?: WPRendered;
  _embedded?: {
    "wp:featuredmedia"?: { source_url?: string; alt_text?: string }[];
    "wp:term"?: { name: string; taxonomy: string }[][];
  };
};

export type Post = {
  id: number;
  slug: string;
  date: string;
  title: string;
  excerpt: string;
  html?: string;
  image?: { src: string; alt: string };
  category?: string;
};

const entities: Record<string, string> = { "&#8217;": "’", "&#8216;": "‘", "&#8220;": "“", "&#8221;": "”", "&#8211;": "-", "&#8212;": "-", "&#038;": "&", "&amp;": "&", "&hellip;": "…", "&#8230;": "…", "&nbsp;": " ", "&#39;": "'", "&quot;": '"' };
export const decode = (s: string) => s.replace(/&#?\w+;/g, (m) => entities[m] ?? m);
const strip = (s: string) => decode(s.replace(/<[^>]+>/g, "")).replace(/\s+/g, " ").trim();

/** Removes scripts, iframes from unknown hosts, inline handlers and dashes used as punctuation. */
function clean(html: string) {
  return html
    .replace(/<script[\s\S]*?<\/script>/gi, "")
    .replace(/<style[\s\S]*?<\/style>/gi, "")
    .replace(/\son\w+="[^"]*"/gi, "")
    .replace(/<iframe(?![^>]*(youtube\.com|youtube-nocookie\.com|player\.vimeo\.com))[\s\S]*?<\/iframe>/gi, "");
}

function map(p: WPPostRaw, withContent = false): Post {
  const media = p._embedded?.["wp:featuredmedia"]?.[0];
  const cat = p._embedded?.["wp:term"]?.flat().find((t) => t.taxonomy === "category" && t.name !== "Uncategorized");
  return {
    id: p.id,
    slug: p.slug,
    date: p.date,
    title: strip(p.title.rendered),
    excerpt: strip(p.excerpt.rendered).replace(/\s*\[…\]\s*$/, "…"),
    html: withContent && p.content ? clean(p.content.rendered) : undefined,
    image: media?.source_url ? { src: media.source_url, alt: media.alt_text || strip(p.title.rendered) } : undefined,
    category: cat?.name,
  };
}

const fields = "id,slug,date,title,excerpt,_links,_embedded";

/** Post listing for the blog index. Degrades to an empty list so the page can show its empty state. */
export async function getPosts(page = 1, perPage = 12): Promise<{ posts: Post[]; totalPages: number }> {
  try {
    const res = await fetch(`${API}/posts?per_page=${perPage}&page=${page}&_embed=wp:featuredmedia,wp:term&_fields=${fields}`, {
      next: { revalidate: REVALIDATE, tags: ["posts"] },
    });
    if (!res.ok) return { posts: [], totalPages: 0 };
    const data: WPPostRaw[] = await res.json();
    return { posts: data.map((p) => map(p)), totalPages: Number(res.headers.get("x-wp-totalpages") ?? 1) };
  } catch {
    return { posts: [], totalPages: 0 };
  }
}

/**
 * Returns null only when WordPress confirms the post does not exist.
 * Network or server errors throw, so a temporary outage is never cached as a 404.
 */
export async function getPost(slug: string): Promise<Post | null> {
  const res = await fetch(`${API}/posts?slug=${encodeURIComponent(slug)}&_embed=wp:featuredmedia,wp:term&_fields=${fields},content`, {
    next: { revalidate: REVALIDATE, tags: ["posts", `post:${slug}`] },
  });
  if (!res.ok) throw new Error(`WordPress responded ${res.status} for post "${slug}"`);
  const data: WPPostRaw[] = await res.json();
  return data[0] ? map(data[0], true) : null;
}

export const formatDate = (iso: string) =>
  new Date(iso).toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" });
