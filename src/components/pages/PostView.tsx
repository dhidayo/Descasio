import Image from "next/image";
import Link from "next/link";
import { ArrowLeft } from "@phosphor-icons/react/dist/ssr";
import type { Post } from "@/lib/wordpress";
import { formatDate } from "@/lib/wordpress";
import { CtaBand } from "@/components/ui/CtaBand";

export function PostView({ post }: { post: Post }) {
  return (
    <>
      <article className="mx-auto max-w-3xl px-4 pt-36 md:pt-40">
        <Link href="/blog" className="inline-flex items-center gap-2 text-[15px] font-semibold text-muted hover:text-fg">
          <ArrowLeft size={16} weight="bold" /> All articles
        </Link>
        <div className="mt-8 flex flex-wrap items-center gap-3 text-sm">
          {post.category && <span className="rounded-full bg-accent-soft px-3 py-1 font-bold text-accent-strong dark:text-accent">{post.category}</span>}
          <time dateTime={post.date} className="text-muted">{formatDate(post.date)}</time>
        </div>
        <h1 className="mt-5 text-balance text-4xl font-extrabold leading-[1.08] tracking-[-0.035em] text-fg md:text-5xl">{post.title}</h1>
        {post.image && (
          <div className="glass relative mt-10 aspect-[16/9] overflow-hidden rounded-[var(--radius-card)] p-1.5">
            <Image src={post.image.src} alt={post.image.alt} fill priority sizes="(min-width: 768px) 720px, 100vw" className="rounded-[18px] object-cover" />
          </div>
        )}
        <div className="prose-descasio mt-10" dangerouslySetInnerHTML={{ __html: post.html ?? "" }} />
      </article>
      <CtaBand />
    </>
  );
}
