import Image from "next/image";
import { clients } from "@/content/site";

export function LogoMarquee() {
  const row = [...clients, ...clients];
  return (
    <section className="py-20" aria-labelledby="clients-heading">
      <h2 id="clients-heading" className="mx-auto max-w-2xl px-4 text-center text-lg font-semibold text-muted">
        Trusted by 400+ organisations across every major industry in Nigeria
      </h2>
      <div className="marquee relative mt-10 overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_12%,#000_88%,transparent)]">
        <ul className="marquee-track flex w-max gap-4">
          {row.map((c, i) => (
            <li key={`${c.id}-${i}`} aria-hidden={i >= clients.length} className="grid h-24 w-36 shrink-0 place-items-center rounded-2xl bg-white p-3 shadow-[0_8px_24px_-14px_rgb(14_26_43/0.35)] ring-1 ring-black/5">
              <Image src={c.src} alt={i < clients.length ? c.alt : ""} width={120} height={120} className="max-h-full w-auto object-contain" />
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
