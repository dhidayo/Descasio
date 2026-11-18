"use client";

import { ArrowCounterClockwise } from "@phosphor-icons/react";

export default function Error({ reset }: { error: Error; reset: () => void }) {
  return (
    <section className="mx-auto flex min-h-[80dvh] max-w-3xl flex-col items-center justify-center px-4 pt-28 text-center">
      <h1 className="text-4xl font-extrabold tracking-[-0.03em] text-fg md:text-5xl">Something went wrong</h1>
      <p className="mt-4 max-w-md text-lg leading-relaxed text-muted">This page couldn&apos;t load just now. Please try again in a moment.</p>
      <button
        type="button"
        onClick={reset}
        className="mt-8 inline-flex items-center gap-2 rounded-full bg-accent-strong px-6 py-3 font-semibold text-white transition-transform hover:-translate-y-0.5 active:scale-[0.98]"
      >
        <ArrowCounterClockwise size={16} weight="bold" /> Try again
      </button>
    </section>
  );
}
