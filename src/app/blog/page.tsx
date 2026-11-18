import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { ArrowLeft, ArrowRight, Article } from "@phosphor-icons/react/dist/ssr";
import { PageHero } from "@/components/ui/PageHero";
import { Reveal } from "@/components/ui/Reveal";
import { getPosts, formatDate } from "@/lib/wordpress";

export const metadata: Metadata = {
  title: "Blog",
  description: "Insights on cloud, AI, and enterprise technology in Africa, from the team building Africa's digital infrastructure.",
};
export const revalidate = 3600;

export default async function Blog({ searchParams }: { searchParams: Promise<{ page?: string }> }) {
  const page = Math.max(1, Number((await searchParams).page) || 1);
  const { posts, totalPages } = await getPosts(page, 12);

  return (
    <>
      <PageHero
        label="Blog"
        title={
          <>
            Insights on cloud, AI, and enterprise technology <span className="text-accent-strong dark:text-accent">in Africa.</span>
          </>
        }
        intro="Perspectives from the team building Africa's digital infrastructure."
      />
      <section className="mx-auto max-w-6xl px-4 py-8">
        {posts.length === 0 ? (
          <div className="glass flex flex-col items-start gap-3 rounded-[var(--radius-card)] p-10">
            <Article size={36} weight="duotone" className="text-accent" />
            <h2 className="text-xl font-bold text-fg">Articles are unavailable right now</h2>
            <p className="text-muted">We couldn&apos;t load the latest articles. Please refresh in a moment.</p>
          </div>
        ) : (
          <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            {posts.map((p, i) => (
              <Reveal key={p.id} delay={(i % 3) * 0.06}>
                <Link href={`/${p.slug}/`} className="glass group flex h-full flex-col overflow-hidden rounded-[var(--radius-card)] p-1.5 transition-transform duration-500 hover:-translate-y-1">
                  <div className="relative aspect-[16/10] overflow-hidden rounded-[17px] bg-accent-soft">
                    {p.image ? (
                      <Image src={p.image.src} alt={p.image.alt} fill sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw" className="object-cover transition-transform duration-700 group-hover:scale-[1.04]" />
                    ) : (
                      <Article size={40} weight="duotone" className="absolute inset-0 m-auto text-accent" />
                    )}
                  </div>
                  <div className="flex flex-1 flex-col p-5">
                    <div className="flex flex-wrap items-center gap-2 text-[13px]">
                      {p.category && <span className="font-bold text-accent-strong dark:text-accent">{p.category}</span>}
                      <time dateTime={p.date} className="text-muted">{formatDate(p.date)}</time>
                    </div>
                    <h2 className="mt-3 text-lg font-bold leading-snug text-fg">{p.title}</h2>
                    <p className="mt-2 line-clamp-3 text-[15px] leading-relaxed text-muted">{p.excerpt}</p>
                  </div>
                </Link>
              </Reveal>
            ))}
          </div>
        )}

        {totalPages > 1 && (
          <nav aria-label="Pagination" className="mt-12 flex items-center justify-between">
            {page > 1 ? (
              <Link href={`/blog/?page=${page - 1}`} className="glass inline-flex items-center gap-2 rounded-full px-5 py-2.5 font-semibold text-fg">
                <ArrowLeft size={16} weight="bold" /> Newer
              </Link>
            ) : <span />}
            <span className="text-[15px] text-muted">Page {page} of {totalPages}</span>
            {page < totalPages ? (
              <Link href={`/blog/?page=${page + 1}`} className="glass inline-flex items-center gap-2 rounded-full px-5 py-2.5 font-semibold text-fg">
                Older <ArrowRight size={16} weight="bold" />
              </Link>
            ) : <span />}
          </nav>
        )}
      </section>
    </>
  );
}
