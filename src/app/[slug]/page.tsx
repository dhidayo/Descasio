import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { services, getService } from "@/content/services";
import { getPost } from "@/lib/wordpress";
import { ServiceView } from "@/components/pages/ServiceView";
import { PostView } from "@/components/pages/PostView";

// Service pages are pre-rendered. Any other slug is looked up as a WordPress post,
// which keeps the live site's root-level blog URLs (descasio.io/<post-slug>/) working.
export const generateStaticParams = () => services.map((s) => ({ slug: s.slug }));
export const revalidate = 3600;

type Props = { params: Promise<{ slug: string }> };

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const s = getService(slug);
  if (s) return { title: s.title, description: s.intro };
  const post = await getPost(slug).catch(() => null);
  if (!post) return {};
  return {
    title: post.title,
    description: post.excerpt,
    openGraph: { type: "article", images: post.image ? [post.image.src] : undefined },
  };
}

export default async function SlugPage({ params }: Props) {
  const { slug } = await params;
  const s = getService(slug);
  if (s) return <ServiceView s={s} />;
  const post = await getPost(slug);
  if (!post) notFound();
  return <PostView post={post} />;
}
