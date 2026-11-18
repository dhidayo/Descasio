import type { ReactNode } from "react";

/** Stacked section header: headline, then optional body. */
export function SectionHeading({
  title,
  body,
  align = "left",
  as: Tag = "h2",
}: {
  title: ReactNode;
  body?: ReactNode;
  align?: "left" | "center";
  as?: "h1" | "h2";
}) {
  return (
    <div className={align === "center" ? "mx-auto max-w-3xl text-center" : "max-w-3xl"}>
      <Tag className="text-balance text-[2.2rem] font-extrabold leading-[1.08] tracking-[-0.03em] text-fg md:text-5xl">
        {title}
      </Tag>
      {body && (
        <p className={`mt-5 max-w-[60ch] text-lg leading-relaxed text-muted ${align === "center" ? "mx-auto" : ""}`}>
          {body}
        </p>
      )}
    </div>
  );
}

/** Brand emphasis: same family, accent colour. */
export function Em({ children }: { children: ReactNode }) {
  return <span className="text-accent-strong dark:text-accent">{children}</span>;
}
