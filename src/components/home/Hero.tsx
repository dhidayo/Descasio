"use client";

import Image from "next/image";
import { motion, useMotionValue, useReducedMotion, useSpring, useTransform } from "motion/react";
import { Certificate, UsersThree } from "@phosphor-icons/react";
import { Button } from "@/components/ui/Button";
import { ctas } from "@/content/site";

const ease = [0.16, 1, 0.3, 1] as const;

export function Hero() {
  const reduce = useReducedMotion();
  const mx = useMotionValue(0);
  const my = useMotionValue(0);
  const sx = useSpring(mx, { stiffness: 80, damping: 20 });
  const sy = useSpring(my, { stiffness: 80, damping: 20 });
  // Each layer moves a different distance, which gives the glass stack depth.
  const back = { x: useTransform(sx, (v) => v * -14), y: useTransform(sy, (v) => v * -14) };
  const mid = { x: useTransform(sx, (v) => v * 10), y: useTransform(sy, (v) => v * 10) };
  const front = { x: useTransform(sx, (v) => v * 22), y: useTransform(sy, (v) => v * 22) };

  const rise = (d: number) => ({
    initial: { opacity: 0, y: 28 },
    animate: { opacity: 1, y: 0 },
    transition: { duration: 0.9, delay: d, ease },
  });

  return (
    <section
      className="relative mx-auto grid min-h-[100dvh] max-w-6xl items-center gap-14 px-4 pb-16 pt-28 md:pt-24 lg:grid-cols-[1.1fr_0.9fr] lg:gap-8"
      onPointerMove={(e) => {
        if (reduce) return;
        const r = e.currentTarget.getBoundingClientRect();
        mx.set((e.clientX - r.left) / r.width - 0.5);
        my.set((e.clientY - r.top) / r.height - 0.5);
      }}
    >
      <div>
        <motion.p {...rise(0)} className="inline-flex items-center gap-2 rounded-full bg-accent-soft px-3.5 py-1.5 text-sm font-bold text-accent-strong dark:text-accent">
          15 years of proven delivery
        </motion.p>
        <motion.h1
          {...rise(0.08)}
          className="mt-6 text-balance text-[2.75rem] font-extrabold leading-[1.02] tracking-[-0.04em] text-fg sm:text-6xl lg:text-[4.6rem]"
        >
          Cloud. Automation. <span className="text-accent-strong dark:text-accent">AI.</span>
        </motion.h1>
        <motion.p {...rise(0.16)} className="mt-6 max-w-[34ch] text-lg leading-relaxed text-muted md:text-xl">
          We build the cloud, automate the workflows and transform the enterprise. Built in Nigeria, owned end to end.
        </motion.p>
        <motion.div {...rise(0.24)} className="mt-9 flex flex-wrap gap-3">
          <Button href={ctas.primary.href}>{ctas.primary.label}</Button>
          <Button href={ctas.solutions.href} variant="glass" arrow={false}>
            {ctas.solutions.label}
          </Button>
        </motion.div>
      </div>

      {/* Visual: the logo swirl behind a stack of glass panels carrying real proof points */}
      <div className="relative mx-auto aspect-[4/5] w-full max-w-[520px] sm:aspect-square">
        <motion.div style={back} className="absolute inset-x-[10%] top-[18%] aspect-square sm:inset-[8%] sm:aspect-auto">
          <motion.div
            initial={{ opacity: 0, scale: 0.85, rotate: -40 }}
            animate={{ opacity: 1, scale: 1, rotate: 0 }}
            transition={{ duration: 1.6, ease }}
            className="size-full"
          >
            <Image src="/brand/descasio-mark.svg" unoptimized alt="" width={225} height={225} priority className="turn size-full opacity-90" />
          </motion.div>
        </motion.div>

        <motion.div style={mid} className="absolute left-0 top-[4%] w-[82%] sm:top-[14%] sm:w-[62%]">
          <motion.div {...rise(0.45)} className="glass rounded-[var(--radius-card)] p-5">
            <div className="flex items-center gap-3">
              <span className="grid size-10 place-items-center rounded-full bg-accent-soft text-accent-strong dark:text-accent">
                <Certificate size={22} weight="duotone" />
              </span>
              <div>
                <p className="text-[15px] font-bold leading-tight text-fg">AWS Advanced Consulting Partner</p>
                <p className="mt-0.5 text-[13px] text-muted">Plus the AWS AI Competency</p>
              </div>
            </div>
          </motion.div>
        </motion.div>

        <motion.div style={front} className="absolute bottom-[2%] right-0 w-[86%] sm:bottom-[8%] sm:w-[70%]">
          <motion.div {...rise(0.6)} className="glass rounded-[var(--radius-card)] p-5">
            <div className="flex items-center -space-x-3">
              {["/team/Dele-Nedd.png", "/team/Femi-Olugbesan.png"].map((src, i) => (
                <Image
                  key={src}
                  src={src}
                  alt={i === 0 ? "Dele Nedd" : "Femi Olugbesan"}
                  width={96}
                  height={96}
                  className="size-12 rounded-full border-2 border-[var(--bg-elevated)] object-cover object-top"
                />
              ))}
              <span className="!ml-3 grid size-12 place-items-center rounded-full bg-accent-strong text-white">
                <UsersThree size={22} weight="bold" />
              </span>
            </div>
            <p className="mt-4 text-2xl font-extrabold tracking-tight text-fg">70+ specialists</p>
            <p className="mt-1 text-[14px] leading-snug text-muted">
              Engineers, consultants and operators led by co-founders Dele Nedd and Femi Olugbesan.
            </p>
          </motion.div>
        </motion.div>
      </div>
    </section>
  );
}
