import { Check } from "@phosphor-icons/react/dist/ssr";

export function CheckList({ items, className = "" }: { items: string[]; className?: string }) {
  return (
    <ul className={`space-y-3 ${className}`}>
      {items.map((i) => (
        <li key={i} className="flex gap-3 leading-snug text-fg">
          <span className="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-accent-soft text-accent-strong dark:text-accent">
            <Check size={12} weight="bold" />
          </span>
          <span>{i}</span>
        </li>
      ))}
    </ul>
  );
}
