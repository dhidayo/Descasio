"use client";

import { motion } from "motion/react";
import { CheckCircle, ShieldCheck } from "@phosphor-icons/react";
import { evidenceTrail } from "@/content/dip";

const ease = [0.16, 1, 0.3, 1] as const;

/**
 * DIP's evidence trail. Stages confirm one after another, which shows the product's core idea:
 * a number is only trusted once every step from source to insight has been checked.
 */
export function EvidenceTrail({ className = "" }: { className?: string }) {
  return (
    <div className={`glass rounded-[28px] p-6 md:p-7 ${className}`}>
      <div className="flex items-center justify-between">
        <p className="text-[15px] font-bold text-fg">Evidence trail</p>
        <span className="inline-flex items-center gap-2 rounded-full bg-accent-soft px-3 py-1 text-xs font-bold text-accent-strong dark:text-accent">
          <span className="relative flex size-2">
            <span className="absolute inline-flex size-full animate-ping rounded-full bg-accent opacity-60 motion-reduce:animate-none" />
            <span className="relative inline-flex size-2 rounded-full bg-accent" />
          </span>
          Live
        </span>
      </div>

      <ol className="relative mt-6">
        {/* Spine that fills as stages verify */}
        <span aria-hidden className="absolute left-[15px] top-4 bottom-4 w-0.5 rounded-full bg-line" />
        <motion.span
          aria-hidden
          className="absolute left-[15px] top-4 w-0.5 origin-top rounded-full bg-accent"
          initial={{ height: 0 }}
          whileInView={{ height: "calc(100% - 2rem)" }}
          viewport={{ once: true }}
          transition={{ duration: 2.4, ease: "linear", delay: 0.3 }}
        />
        {evidenceTrail.map((s, i) => (
          <motion.li
            key={s.stage}
            className="relative flex items-center gap-4 py-2.5"
            initial={{ opacity: 0.35 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.4, delay: 0.3 + i * 0.4 }}
          >
            <motion.span
              className="relative z-10 grid size-8 shrink-0 place-items-center rounded-full border-2 border-line bg-[var(--bg-elevated)]"
              initial={{ scale: 0.8 }}
              whileInView={{ scale: 1, borderColor: "var(--accent)" }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: 0.3 + i * 0.4, ease }}
            >
              <span className="text-[11px] font-bold text-muted">{String(i + 1).padStart(2, "0")}</span>
            </motion.span>
            <span className="flex-1 text-[15px] font-semibold text-fg">{s.stage}</span>
            <motion.span
              className="inline-flex items-center gap-1.5 text-sm font-semibold text-accent-strong dark:text-accent"
              initial={{ opacity: 0, x: -6 }}
              whileInView={{ opacity: 1, x: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.4, delay: 0.5 + i * 0.4, ease }}
            >
              <CheckCircle size={16} weight="fill" />
              {s.state}
            </motion.span>
          </motion.li>
        ))}
      </ol>

      <motion.div
        className="mt-5 flex items-center gap-3 rounded-[16px] bg-accent-strong px-4 py-3.5 text-white"
        initial={{ opacity: 0, y: 10 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: 0.6, delay: 0.3 + evidenceTrail.length * 0.4, ease }}
      >
        <ShieldCheck size={22} weight="duotone" />
        <span className="text-[15px] font-semibold">Every number traceable from source to decision</span>
      </motion.div>
    </div>
  );
}
