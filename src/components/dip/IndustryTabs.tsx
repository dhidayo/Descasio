"use client";

import { AnimatePresence, motion } from "motion/react";
import { useId, useState } from "react";
import { industries } from "@/content/dip";

const ease = [0.16, 1, 0.3, 1] as const;

export function IndustryTabs() {
  const [active, setActive] = useState(0);
  const id = useId();
  const current = industries[active];

  return (
    <div>
      <div role="tablist" aria-label="Industries" className="glass inline-flex rounded-full p-1.5">
        {industries.map((ind, i) => (
          <button
            key={ind.name}
            role="tab"
            id={`${id}-tab-${i}`}
            aria-selected={active === i}
            aria-controls={`${id}-panel`}
            onClick={() => setActive(i)}
            className={`relative rounded-full px-5 py-2.5 text-[15px] font-semibold transition-colors ${active === i ? "text-white" : "text-fg/75 hover:text-fg"}`}
          >
            {active === i && (
              <motion.span layoutId={`${id}-pill`} className="absolute inset-0 rounded-full bg-accent-strong" transition={{ type: "spring", stiffness: 380, damping: 32 }} />
            )}
            <span className="relative">{ind.name}</span>
          </button>
        ))}
      </div>

      <div id={`${id}-panel`} role="tabpanel" aria-labelledby={`${id}-tab-${active}`} className="mt-8">
        <AnimatePresence mode="wait" initial={false}>
          <motion.ul
            key={current.name}
            className="grid gap-5 md:grid-cols-3"
            initial={{ opacity: 0, y: 12 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -8 }}
            transition={{ duration: 0.35, ease }}
          >
            {current.roles.map((r) => (
              <li key={r.role} className="glass rounded-[var(--radius-card)] p-7">
                <h3 className="text-lg font-bold text-fg">{r.role}</h3>
                <p className="mt-1 text-sm font-semibold text-accent-strong dark:text-accent">What they see in DIP</p>
                <p className="mt-3 leading-relaxed text-muted">{r.sees}</p>
              </li>
            ))}
          </motion.ul>
        </AnimatePresence>
      </div>
    </div>
  );
}
