import Link from "next/link";
import { ArrowRight } from "@phosphor-icons/react/dist/ssr";
import type { ComponentProps } from "react";

type Variant = "primary" | "glass";

const base =
  "group inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-full px-6 py-3 text-[15px] font-semibold transition-[transform,background-color,box-shadow] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] active:scale-[0.98]";

const variants: Record<Variant, string> = {
  // White on #C63B1C is 5.2:1 (WCAG AA)
  primary:
    "bg-accent-strong text-white shadow-[inset_0_1px_0_rgb(255_255_255/0.25),0_12px_30px_-12px_rgb(198_59_28/0.7)] hover:bg-[var(--accent-strong-hover)] hover:-translate-y-0.5",
  glass: "glass text-fg hover:-translate-y-0.5",
};

type Props = Omit<ComponentProps<typeof Link>, "className"> & {
  variant?: Variant;
  arrow?: boolean;
  className?: string;
};

export function Button({ variant = "primary", arrow = true, className = "", children, href, ...rest }: Props) {
  const external = typeof href === "string" && href.startsWith("http");
  return (
    <Link
      href={href}
      className={`${base} ${variants[variant]} ${className}`}
      {...(external ? { target: "_blank", rel: "noopener noreferrer" } : {})}
      {...rest}
    >
      {children}
      {arrow && (
        <ArrowRight size={16} weight="bold" aria-hidden className="transition-transform duration-300 group-hover:translate-x-0.5" />
      )}
    </Link>
  );
}
