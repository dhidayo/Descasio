import { stats } from "@/content/site";
import { CountUp } from "@/components/ui/CountUp";
import { Reveal } from "@/components/ui/Reveal";

export function Stats() {
  return (
    <section className="mx-auto max-w-6xl px-4">
      <Reveal className="glass grid grid-cols-2 gap-y-10 rounded-[28px] px-6 py-10 md:grid-cols-4 md:px-10">
        {stats.map((s, i) => (
          <div key={s.label} className={`px-2 md:px-6 ${i > 0 ? "md:border-l md:border-line" : ""}`}>
            <p className="text-4xl font-extrabold tracking-[-0.04em] text-fg md:text-5xl">
              <CountUp to={s.value} suffix={s.suffix} />
            </p>
            <p className="mt-2 max-w-[22ch] text-[15px] leading-snug text-muted">{s.label}</p>
          </div>
        ))}
      </Reveal>
    </section>
  );
}
