"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { AnimatePresence, motion, useMotionValueEvent, useScroll } from "motion/react";
import {
  ArrowRight, Article, BookOpenText, Briefcase, Brain, Buildings, CalendarStar, CaretDown, ChartLineUp, ChatsCircle, CloudArrowUp,
  CurrencyCircleDollar, Exam, FlowArrow, Handshake, List, Megaphone, ShieldCheck, Sparkle, Trophy, UsersThree, X, ArrowsClockwise,
  ClockCounterClockwise, type Icon,
} from "@phosphor-icons/react";
import { useEffect, useRef, useState } from "react";
import { nav, ctas, company, type NavGroup, type NavLink } from "@/content/site";
import { dip } from "@/content/dip";
import { Logo } from "@/components/ui/Logo";
import { ThemeToggle } from "./ThemeToggle";

const isGroup = (i: NavLink | NavGroup): i is NavGroup => "groups" in i;
// "Home" is reached through the logo, which keeps the desktop bar on one line.
const items = nav.filter((i) => !(!isGroup(i) && i.href === "/"));
const ease = [0.16, 1, 0.3, 1] as const;

const icons: Record<string, Icon> = {
  "/sovereign-cloud": CloudArrowUp,
  "/cloud-migration": ArrowsClockwise,
  "/cybersecurity": ShieldCheck,
  "/backup": ClockCounterClockwise,
  "/decision-intelligence-platform": ChartLineUp,
  "/plugiq": FlowArrow,
  "/ai-advisory": Brain,
  "/ai-readiness": Exam,
  "/ai-competency": Trophy,
  "/cost-optimization": CurrencyCircleDollar,
  "/blog": Article,
  "/whitepapers": BookOpenText,
  "/case-studies": Briefcase,
  "/events": CalendarStar,
  "/press": Megaphone,
  "/about": Buildings,
  "/partners": Handshake,
  "/careers": UsersThree,
  "/contact": ChatsCircle,
};

export function Nav() {
  const [open, setOpen] = useState<string | null>(null);
  const [mobile, setMobile] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const pathname = usePathname();
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
    const onKey = (e: KeyboardEvent) => {
      if (e.key === "Escape") {
        setOpen(null);
        setMobile(false);
      }
    };
    window.addEventListener("keydown", onKey);
    return () => window.removeEventListener("keydown", onKey);
  }, []);

  const enter = (label: string) => {
    clearTimeout(closeTimer.current);
    setOpen(label);
  };
  const leave = () => {
    closeTimer.current = setTimeout(() => setOpen(null), 160);
  };

  const solid = scrolled || mobile || open !== null;

  return (
    <header className="fixed inset-x-0 top-0 z-40 px-4 pt-3 md:pt-4">
      {/* Soft scrim behind open menus: focuses attention and closes on click */}
      <AnimatePresence>
        {(open || mobile) && (
          <motion.div
            aria-hidden
            className="fixed inset-0 -z-10 bg-[rgb(10_18_32/0.22)] backdrop-blur-[2px] dark:bg-[rgb(0_0_0/0.45)]"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            transition={{ duration: 0.25 }}
            onClick={() => {
              setOpen(null);
              setMobile(false);
            }}
          />
        )}
      </AnimatePresence>

      <nav
        aria-label="Main"
        className={`relative mx-auto flex h-16 max-w-6xl items-center justify-between rounded-full pl-5 pr-2 transition-[background,box-shadow,border-color] duration-500 ${
          solid ? "glass-nav" : "border border-transparent"
        }`}
      >
        <Link href="/" aria-label="Descasio home" className="shrink-0">
          <Logo className="h-[26px] w-auto" />
        </Link>

        <ul className="hidden items-center gap-1 lg:flex">
          {items.map((item) => {
            if (!isGroup(item)) {
              const active = pathname?.startsWith(item.href);
              return (
                <li key={item.href}>
                  <Link
                    href={item.href}
                    className={`rounded-full px-4 py-2 text-[15px] font-semibold transition-colors hover:text-fg ${active ? "text-accent-strong dark:text-accent" : "text-fg/80"}`}
                  >
                    {item.label}
                  </Link>
                </li>
              );
            }
            const mega = item.groups.length > 1;
            const isOpen = open === item.label;
            return (
              <li key={item.label} className={mega ? "" : "relative"} onMouseEnter={() => enter(item.label)} onMouseLeave={leave}>
                <button
                  type="button"
                  aria-expanded={isOpen}
                  aria-haspopup="true"
                  onClick={() => setOpen(isOpen ? null : item.label)}
                  className={`flex items-center gap-1 rounded-full px-4 py-2 text-[15px] font-semibold transition-colors hover:text-fg ${isOpen ? "bg-accent-soft text-fg" : "text-fg/80"}`}
                >
                  {item.label}
                  <CaretDown size={13} weight="bold" className={`transition-transform duration-300 ${isOpen ? "rotate-180" : ""}`} />
                </button>
                <AnimatePresence>
                  {isOpen && (
                    <motion.div
                      initial={{ opacity: 0, y: 10, scale: 0.985 }}
                      animate={{ opacity: 1, y: 0, scale: 1 }}
                      exit={{ opacity: 0, y: 6, scale: 0.985 }}
                      transition={{ duration: 0.28, ease }}
                      className={
                        mega
                          ? "absolute inset-x-0 top-full origin-top pt-3"
                          : "absolute left-1/2 top-full w-[360px] origin-top -translate-x-1/2 pt-3"
                      }
                    >
                      {mega ? <MegaPanel group={item} /> : <ListPanel group={item} />}
                    </motion.div>
                  )}
                </AnimatePresence>
              </li>
            );
          })}
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
            onClick={() => {
              setOpen(null);
              setMobile((m) => !m);
            }}
            aria-expanded={mobile}
            aria-label={mobile ? "Close menu" : "Open menu"}
            className="grid size-10 place-items-center rounded-full text-fg transition-colors hover:bg-accent-soft lg:hidden"
          >
            {mobile ? <X size={22} weight="bold" /> : <List size={22} weight="bold" />}
          </button>
        </div>
      </nav>

      <AnimatePresence>
        {mobile && (
          <motion.div
            initial={{ opacity: 0, y: -8, scale: 0.99 }}
            animate={{ opacity: 1, y: 0, scale: 1 }}
            exit={{ opacity: 0, y: -8, scale: 0.99 }}
            transition={{ duration: 0.3, ease }}
            className="glass-menu mx-auto mt-2 max-h-[calc(100dvh-6rem)] max-w-6xl origin-top overflow-y-auto rounded-[24px] p-3 lg:hidden"
            data-lenis-prevent
          >
            <MobileMenu />
          </motion.div>
        )}
      </AnimatePresence>
    </header>
  );
}

function MenuLink({ link }: { link: NavLink }) {
  const Icon = icons[link.href] ?? Sparkle;
  return (
    <Link href={link.href} className="group/link flex items-start gap-3 rounded-[14px] p-2.5 transition-colors hover:bg-accent-soft focus-visible:bg-accent-soft">
      <span className="grid size-9 shrink-0 place-items-center rounded-[10px] border border-line bg-[var(--bg)] text-accent-strong transition-colors group-hover/link:border-transparent group-hover/link:bg-accent-strong group-hover/link:text-white dark:text-accent dark:group-hover/link:text-white">
        <Icon size={18} weight="duotone" />
      </span>
      <span className="min-w-0 pt-0.5">
        <span className="block text-[14.5px] font-semibold leading-tight text-fg">{link.label}</span>
        {link.description && <span className="mt-1 block text-[13px] leading-snug text-muted">{link.description}</span>}
      </span>
    </Link>
  );
}

/** Solutions: featured DIP card plus three columns. */
function MegaPanel({ group }: { group: NavGroup }) {
  return (
    <div className="glass-menu overflow-hidden rounded-[24px]">
      <div className="grid grid-cols-[250px_1fr] gap-2 p-2">
        <Link
          href={dip.href}
          className="group/dip relative flex flex-col justify-between overflow-hidden rounded-[18px] bg-accent-strong p-5 text-white"
        >
          <div aria-hidden className="pointer-events-none absolute -bottom-16 -right-16 size-48 rounded-full bg-white/10" />
          <div className="relative">
            <span className="inline-flex rounded-full bg-white/15 px-2.5 py-1 text-[11px] font-bold">Flagship platform</span>
            <ChartLineUp size={30} weight="duotone" className="mt-5" />
            <p className="mt-3 text-lg font-extrabold leading-tight">Decision Intelligence Platform</p>
            <p className="mt-2 text-[13.5px] leading-snug text-white/85">Turn fragmented data into decisions you can trust.</p>
          </div>
          <span className="relative mt-6 inline-flex items-center gap-1.5 text-sm font-semibold">
            Explore DIP <ArrowRight size={14} weight="bold" className="transition-transform group-hover/dip:translate-x-1" />
          </span>
        </Link>
        <div className="grid grid-cols-3 gap-1 p-2">
          {group.groups.map((g) => (
            <div key={g.title}>
              <p className="px-2.5 pb-2 pt-1 text-xs font-bold text-muted">{g.title}</p>
              <ul className="space-y-0.5">
                {g.links.map((l) => (
                  <li key={l.href}>
                    <MenuLink link={l} />
                  </li>
                ))}
              </ul>
            </div>
          ))}
        </div>
      </div>
      <div className="flex items-center justify-between border-t border-line bg-[var(--bg)]/60 px-5 py-3 text-[14px]">
        <span className="text-muted">Not sure where to start? We&apos;ll help you find the highest-impact first step.</span>
        <div className="flex items-center gap-5">
          <Link href="/solutions" className="font-semibold text-fg hover:text-accent-strong dark:hover:text-accent">
            All solutions
          </Link>
          <Link href={ctas.primary.href} target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-1 font-semibold text-accent-strong dark:text-accent">
            {ctas.primary.label} <ArrowRight size={14} weight="bold" />
          </Link>
        </div>
      </div>
    </div>
  );
}

/** Resources and Company: one column of links with a short footer. */
function ListPanel({ group }: { group: NavGroup }) {
  const links = group.groups.flatMap((g) => g.links);
  const footer =
    group.label === "Company"
      ? { text: company.email, href: `mailto:${company.email}` }
      : { text: "Take the free AI Readiness Assessment", href: "/ai-readiness" };
  return (
    <div className="glass-menu overflow-hidden rounded-[22px]">
      <ul className="space-y-0.5 p-2">
        {links.map((l) => (
          <li key={l.href}>
            <MenuLink link={l} />
          </li>
        ))}
      </ul>
      <Link
        href={footer.href}
        className="flex items-center justify-between border-t border-line bg-[var(--bg)]/60 px-5 py-3 text-[14px] font-semibold text-accent-strong dark:text-accent"
      >
        {footer.text}
        <ArrowRight size={14} weight="bold" />
      </Link>
    </div>
  );
}

function MobileMenu() {
  return (
    <div className="flex flex-col gap-1">
      <Link href={dip.href} className="mb-2 flex items-center gap-3 rounded-[16px] bg-accent-strong p-4 text-white">
        <ChartLineUp size={26} weight="duotone" className="shrink-0" />
        <span className="min-w-0">
          <span className="block text-[11px] font-bold text-white/80">Flagship platform</span>
          <span className="block font-bold leading-tight">Decision Intelligence Platform</span>
        </span>
        <ArrowRight size={16} weight="bold" className="ml-auto shrink-0" />
      </Link>
      {nav.map((item) =>
        isGroup(item) ? (
          <details key={item.label} className="group rounded-[16px] open:bg-[var(--bg)]/60">
            <summary className="flex cursor-pointer list-none items-center justify-between rounded-[16px] px-3 py-3 text-base font-bold text-fg">
              {item.label}
              <CaretDown size={15} weight="bold" className="transition-transform group-open:rotate-180" />
            </summary>
            <div className="px-1 pb-2">
              {item.groups.map((g) => (
                <div key={g.title}>
                  {item.groups.length > 1 && <p className="px-2.5 pb-1 pt-2 text-xs font-bold text-muted">{g.title}</p>}
                  <ul>
                    {g.links.map((l) => (
                      <li key={l.href}>
                        <MenuLink link={l} />
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </details>
        ) : (
          <Link key={item.href} href={item.href} className="rounded-[16px] px-3 py-3 text-base font-bold text-fg">
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
