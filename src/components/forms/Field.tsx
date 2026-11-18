import type { InputHTMLAttributes, ReactNode, SelectHTMLAttributes, TextareaHTMLAttributes } from "react";

// Shape rule: buttons are pills, cards are 22px, inputs are 14px.
const control =
  "w-full rounded-[14px] border bg-[var(--bg-elevated)] px-4 py-3 text-[16px] text-fg placeholder:text-muted/80 transition-[border-color,box-shadow] focus:outline-none focus:ring-4 focus:ring-accent-soft";
const tone = (err?: string) => (err ? "border-accent-strong" : "border-line focus:border-accent");

function Wrap({ id, label, required, error, hint, children }: { id: string; label: string; required?: boolean; error?: string; hint?: string; children: ReactNode }) {
  return (
    <div className="flex flex-col gap-2">
      <label htmlFor={id} className="text-[15px] font-semibold text-fg">
        {label}
        {required && <span className="text-accent-strong dark:text-accent"> *</span>}
      </label>
      {children}
      {hint && !error && <p id={`${id}-hint`} className="text-sm text-muted">{hint}</p>}
      {error && (
        <p id={`${id}-error`} className="text-sm font-semibold text-accent-strong dark:text-accent">
          {error}
        </p>
      )}
    </div>
  );
}

type Common = { name: string; label: string; error?: string; hint?: string };

export function Input({ name, label, error, hint, required, ...rest }: Common & InputHTMLAttributes<HTMLInputElement>) {
  return (
    <Wrap id={name} label={label} required={required} error={error} hint={hint}>
      <input id={name} name={name} required={required} aria-invalid={!!error} aria-describedby={error ? `${name}-error` : hint ? `${name}-hint` : undefined} className={`${control} ${tone(error)}`} {...rest} />
    </Wrap>
  );
}

export function Select({ name, label, error, required, children, ...rest }: Common & SelectHTMLAttributes<HTMLSelectElement>) {
  return (
    <Wrap id={name} label={label} required={required} error={error}>
      <select id={name} name={name} required={required} aria-invalid={!!error} aria-describedby={error ? `${name}-error` : undefined} className={`${control} ${tone(error)} appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 256 256%22><path fill=%22%238592a8%22 d=%22M213.66 101.66l-80 80a8 8 0 0 1-11.32 0l-80-80a8 8 0 0 1 11.32-11.32L128 164.69l74.34-74.35a8 8 0 0 1 11.32 11.32Z%22/></svg>')] bg-[position:right_1rem_center] bg-no-repeat pr-10`} {...rest}>
        {children}
      </select>
    </Wrap>
  );
}

export function Textarea({ name, label, error, required, ...rest }: Common & TextareaHTMLAttributes<HTMLTextAreaElement>) {
  return (
    <Wrap id={name} label={label} required={required} error={error}>
      <textarea id={name} name={name} required={required} aria-invalid={!!error} aria-describedby={error ? `${name}-error` : undefined} className={`${control} ${tone(error)} min-h-36 resize-y`} {...rest} />
    </Wrap>
  );
}

/** Off-screen field that only bots fill in. */
export function Honeypot() {
  return (
    <div aria-hidden className="absolute -left-[9999px] h-0 w-0 overflow-hidden">
      <label htmlFor="website">Website</label>
      <input id="website" name="website" tabIndex={-1} autoComplete="off" />
    </div>
  );
}

export function SubmitButton({ pending, children }: { pending: boolean; children: ReactNode }) {
  return (
    <button
      type="submit"
      disabled={pending}
      className="inline-flex items-center justify-center gap-2 rounded-full bg-accent-strong px-7 py-3.5 text-[15px] font-semibold text-white transition-[transform,background-color,opacity] duration-300 hover:-translate-y-0.5 hover:bg-[var(--accent-strong-hover)] active:scale-[0.98] disabled:translate-y-0 disabled:opacity-70"
    >
      {pending && <span aria-hidden className="size-4 animate-spin rounded-full border-2 border-white/40 border-t-white" />}
      {children}
    </button>
  );
}
