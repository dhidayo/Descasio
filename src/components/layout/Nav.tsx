"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { AnimatePresence, motion, useMotionValueEvent, useReducedMotion, useScroll } from "motion/react";
import { CaretDown, List, X, ArrowRight } from "@phosphor-icons/react";
import { useEffect, useRef, useState } from "react";
import { nav, ctas, type NavGroup, type NavLink } from "@/content/site";
import { Logo } from "@/components/ui/Logo";
import { ThemeToggle } from "./ThemeToggle";

const isGroup = (i: NavLink | NavGroup): i is NavGroup => "groups" in i;
// "Home" is reached through the logo, which keeps the desktop bar on one line.
const items = nav.filter((i) => !(!isGroup(i) && i.href === "/"));
const ease = [0.16, 1, 0.3, 1] as const;

export function Nav() {
  const [open, setOpen] = useState<string | null>(null);
  const [mobile, setMobile] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();
  const reduce = useReducedMotion();
  const closeTimer = useRef<ReturnType<typeof setTimeout>>(undefined);
  const { scrollY } = useScroll();

  useMotionValueEvent(scrollY, "change", (y) => {
    const next = y > 24;
    if (next !== scrolled) setScrolled(next);
  });

  useEffect(() => {
    setOpen(null);
    setMobile(false);
  }, [pathname]);

  useEffect(() => {
    const onKey = (e: KeyboardEvent) => e.key === "Escape" && (setOpen(null), setMobile(false));
    window.addEventListener("keydown", onKey);
    return () => window.removeEventListener("keydown", onKey);
  }, []);

  const enter = (label: string) => {
    clearTimeout(closeTimer.current);
    setOpen(label);
  };
  const leave = () => {
    closeTimer.current = setTimeout(() => setOpen(null), 140);
  };

  return (
    <header className="fixed inset-x-0 top-0 z-40 px-4 pt-3 md:pt-4">
      <nav
        aria-label="Main"
        className={`mx-auto flex h-16 max-w-6xl items-center justify-between rounded-full pl-5 pr-2 transition-[background,box-shadow,border-color] duration-500 ${
          scrolled || mobile ? "glass" : "border border-transparent"
        }`}
      >
        <Link href="/" aria-label="Descasio home" className="shrink-0">
          <Logo className="h-[26px] w-auto" />
        </Link>

        <ul className="hidden items-center gap-1 lg:flex">
          {items.map((item) =>
            isGroup(item) ? (
              <li key={item.label} className="relative" onMouseEnter={() => enter(item.label)} onMouseLeave={leave}>
                <button
                  type="button"
                  aria-expanded={open === item.label}
                  onClick={() => setOpen(open === item.label ? null : item.label)}
                  className="flex items-center gap-1 rounded-full px-4 py-2 text-[15px] font-semibold text-fg/80 transition-colors hover:text-fg"
                >
                  {item.label}
                  <CaretDown
                    size={13}
                    weight="bold"
                    className={`transition-transform duration-300 ${open === item.label ? "rotate-180" : ""}`}
                  />
                </button>
                <AnimatePresence>
                  {open === item.label && (
                    <motion.div
                      initial={reduce ? false : { opacity: 0, y: 8, scale: 0.98 }}
                      animate={{ opacity: 1, y: 0, scale: 1 }}
                      exit={reduce ? { opacity: 0 } : { opacity: 0, y: 6, scale: 0.98 }}
                      transition={{ duration: 0.28, ease }}
                      className="absolute left-1/2 top-full origin-top -translate-x-1/2 pt-3"
                    >
                      <DropPanel group={item} />
                    </motion.div>
                  )}
                </AnimatePresence>
              </li>
            ) : (
              <li key={item.href}>
                <Link
                  href={item.href}
                  className={`rounded-full px-4 py-2 text-[15px] font-semibold transition-colors hover:text-fg ${
                    pathname === item.href ? "text-fg" : "text-fg/80"
                  }`}
                >
                  {item.label}
                </Link>
              </li>
            ),
          )}
        </ul>

        <div className="flex items-center gap-1">
          <ThemeToggle />
          <Link
            href={ctas.primary.href}
            target="_blank"
            rel="noopener noreferrer"
            className="hidden rounded-full bg-accent-strong px-5 py-2.5 text-[14px] font-semibold text-white transition-[transform,background-color] duration-300 hover:-translate-y-0.5 hover:bg-[var(--accent-strong-hover)] active:scale-[0.98] sm:inline-flex"
          >
            {ctas.primary.label}
          </Link>
          <button
            type="button"
            onClick={() => setMobile((m) => !m)}
            aria-expanded={mobile}
            aria-label={mobile ? "Close menu" : "Open menu"}
            className="grid size-10 place-items-center rounded-full text-fg lg:hidden"
          >
            {mobile ? <X size={22} weight="bold" /> : <List size={22} weight="bold" />}
          </button>
        </div>
      </nav>

      <AnimatePresence>
        {mobile && (
          <motion.div
            initial={reduce ? false : { opacity: 0, y: -8 }}
            animate={{ opacity: 1, y: 0 }}
            exit={{ opacity: 0, y: -8 }}
            transition={{ duration: 0.3, ease }}
            className="glass mx-auto mt-2 max-h-[calc(100dvh-6rem)] max-w-6xl overflow-y-auto rounded-[var(--radius-card)] p-4 lg:hidden"
            data-lenis-prevent
          >
            <MobileMenu />
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}

function DropPanel({ group }: { group: NavGroup }) {
  const wide = group.groups.length > 1;
  return (
    <div
      className={`glass rounded-[var(--radius-card)] p-3 ${wide ? "grid w-[760px] grid-cols-3 gap-2" : "w-64"}`}
    >
      {group.groups.map((g) => (
        <div key={g.title} className="p-1">
          {wide && <p className="px-3 pb-2 pt-1 text-xs font-bold text-accent-strong dark:text-accent">{g.title}</p>}
          <ul>
            {g.links.map((l) => (
              <li key={l.href}>
                <Link href={l.href} className="block rounded-2xl px-3 py-2.5 transition-colors hover:bg-accent-soft">
                  <span className="block text-[15px] font-semibold text-fg">{l.label}</span>
                  {l.description && <span className="mt-0.5 block text-[13px] text-muted">{l.description}</span>}
                </Link>
              </li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
}

function MobileMenu() {
  return (
    <div className="flex flex-col gap-1">
      {nav.map((item) =>
        isGroup(item) ? (
          <details key={item.label} className="group rounded-2xl">
            <summary className="flex cursor-pointer list-none items-center justify-between rounded-2xl px-3 py-3 text-base font-bold text-fg">
              {item.label}
              <CaretDown size={15} weight="bold" className="transition-transform group-open:rotate-180" />
            </summary>
            <ul className="pb-2 pl-3">
              {item.groups.flatMap((g) => g.links).map((l) => (
                <li key={l.href}>
                  <Link href={l.href} className="block rounded-xl px-3 py-2 text-[15px] text-muted hover:text-fg">
                    {l.label}
                  </Link>
                </li>
              ))}
            </ul>
          </details>
        ) : (
          <Link key={item.href} href={item.href} className="rounded-2xl px-3 py-3 text-base font-bold text-fg">
            {item.label}
          </Link>
        ),
      )}
      <Link
        href={ctas.primary.href}
        target="_blank"
        rel="noopener noreferrer"
        className="mt-2 inline-flex items-center justify-center gap-2 rounded-full bg-accent-strong px-6 py-3.5 font-semibold text-white"
      >
        {ctas.primary.label}
        <ArrowRight size={16} weight="bold" />
      </Link>
    </div>
  );
}
