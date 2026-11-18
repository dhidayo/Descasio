import Image from "next/image";
import { Button } from "@/components/ui/Button";

export default function NotFound() {
  return (
    <section className="mx-auto flex min-h-[80dvh] max-w-3xl flex-col items-center justify-center px-4 pt-28 text-center">
      <Image src="/brand/descasio-mark.svg" unoptimized alt="" width={120} height={120} className="turn size-24" />
      <h1 className="mt-8 text-5xl font-extrabold tracking-[-0.04em] text-fg">Page not found</h1>
      <p className="mt-4 max-w-md text-lg leading-relaxed text-muted">The page you&apos;re looking for has moved or no longer exists.</p>
      <div className="mt-8 flex flex-wrap justify-center gap-3">
        <Button href="/">Back to home</Button>
        <Button href="/contact" variant="glass" arrow={false}>Contact us</Button>
      </div>
    </section>
  );
}
