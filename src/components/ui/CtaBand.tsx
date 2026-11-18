import Image from "next/image";
import { Button } from "./Button";
import { Reveal } from "./Reveal";
import { ctas } from "@/content/site";

export function CtaBand({
  title = "Ready to stop stitching together vendors?",
  body = "Book a 30-minute strategy session with our team. No pitch deck, no pressure. Just an honest conversation about where your technology needs to go next.",
  label = ctas.primary.label,
  href = ctas.primary.href,
}: { title?: string; body?: string; label?: string; href?: string }) {
  return (
    <section className="mx-auto max-w-6xl px-4 pt-12">
      <Reveal>
        <div className="glass relative overflow-hidden rounded-[32px] px-6 py-16 text-center md:px-16 md:py-20">
          <Image src="/brand/descasio-mark.svg" unoptimized alt="" width={225} height={225} className="turn pointer-events-none absolute -left-24 -top-24 size-80 opacity-[0.12]" />
          <Image src="/brand/descasio-mark.svg" unoptimized alt="" width={225} height={225} className="turn pointer-events-none absolute -bottom-28 -right-20 size-96 opacity-[0.12]" />
          <h2 className="relative mx-auto max-w-2xl text-balance text-4xl font-extrabold leading-[1.06] tracking-[-0.035em] text-fg md:text-5xl">{title}</h2>
          <p className="relative mx-auto mt-5 max-w-[52ch] text-lg leading-relaxed text-muted">{body}</p>
          <div className="relative mt-9 flex justify-center">
            <Button href={href}>{label}</Button>
          </div>
        </div>
      </Reveal>
    </section>
  );
}
