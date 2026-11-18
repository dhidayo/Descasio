"use client";

import { AnimatePresence, motion } from "motion/react";
import { useActionState, useEffect, useMemo, useState } from "react";
import { ArrowLeft, ArrowRight, ArrowCounterClockwise } from "@phosphor-icons/react";
import { dimensions, questions, score } from "@/content/assessment";
import { saveReadiness, type FormState } from "@/lib/actions";
import { ctas } from "@/content/site";
import { Honeypot, Input, Select, SubmitButton } from "./Field";
import { Button } from "@/components/ui/Button";

const ease = [0.16, 1, 0.3, 1] as const;
const empty = () => Array<number>(questions.length).fill(-1);

export function Assessment() {
  const [answers, setAnswers] = useState<number[]>(empty);
  const [step, setStep] = useState(0);
  const [dir, setDir] = useState(1);
  const [state, action, pending] = useActionState<FormState, FormData>(saveReadiness, null);
  const result = useMemo(() => score(answers), [answers]);
  const done = answers.every((a) => a >= 0);
  const phase = state?.ok ? "results" : done && step >= questions.length ? "gate" : "quiz";

  useEffect(() => {
    if (phase === "results") window.scrollTo({ top: 0, behavior: "smooth" });
  }, [phase]);

  const choose = (opt: number) => {
    const next = [...answers];
    next[step] = opt;
    setAnswers(next);
    setDir(1);
    setTimeout(() => setStep((s) => s + 1), 220);
  };
  const back = () => {
    setDir(-1);
    setStep((s) => Math.max(0, s - 1));
  };

  if (phase === "results") return <Results result={result} onRestart={() => location.reload()} />;

  if (phase === "gate") {
    const e = state?.errors ?? {};
    return (
      <motion.div initial={{ opacity: 0, y: 16 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6, ease }}>
        <p className="text-sm font-bold text-accent-strong dark:text-accent">Assessment complete</p>
        <h2 className="mt-2 text-3xl font-extrabold tracking-tight text-fg">
          Your score: <span className="text-accent-strong dark:text-accent">{result.total}/100</span>
        </h2>
        <p className="mt-3 max-w-xl leading-relaxed text-muted">Enter your details to see your full results and personalised recommendations.</p>
        <form action={action} noValidate className="relative mt-8 grid gap-5 sm:grid-cols-2">
          <Honeypot />
          <input type="hidden" name="answers" value={answers.join(",")} />
          <Input name="first_name" label="First name" required autoComplete="given-name" error={e.first_name} />
          <Input name="last_name" label="Last name" required autoComplete="family-name" error={e.last_name} />
          <Input name="email" type="email" label="Work email" required autoComplete="email" error={e.email} />
          <Input name="company" label="Company" required autoComplete="organization" error={e.company} />
          <Input name="job_title" label="Job title" autoComplete="organization-title" error={e.job_title} />
          <Select name="company_size" label="Company size" defaultValue="" error={e.company_size}>
            <option value="">Select...</option>
            {["1-50", "51-200", "201-1000", "1000+"].map((s) => (
              <option key={s} value={s}>
                {s}
              </option>
            ))}
          </Select>
          {state && !state.ok && <p role="alert" className="text-sm font-semibold text-accent-strong dark:text-accent sm:col-span-2">{state.message}</p>}
          <div className="flex flex-wrap items-center gap-4 sm:col-span-2">
            <SubmitButton pending={pending}>{pending ? "Calculating..." : "See My Results"}</SubmitButton>
            <button type="button" onClick={back} className="text-[15px] font-semibold text-muted hover:text-fg">
              Change my answers
            </button>
          </div>
        </form>
      </motion.div>
    );
  }

  const q = questions[Math.min(step, questions.length - 1)];
  const progress = (answers.filter((a) => a >= 0).length / questions.length) * 100;
  return (
    <div>
      <div className="flex items-center justify-between gap-4 text-sm">
        <span className="font-bold text-fg">
          Question {Math.min(step + 1, questions.length)} of {questions.length}
        </span>
        <span className="font-semibold text-accent-strong dark:text-accent">{dimensions[q.dim]}</span>
      </div>
      <div className="mt-3 h-1.5 overflow-hidden rounded-full bg-line" role="progressbar" aria-valuenow={Math.round(progress)} aria-valuemin={0} aria-valuemax={100} aria-label="Assessment progress">
        <motion.div className="h-full rounded-full bg-accent" animate={{ width: `${progress}%` }} transition={{ duration: 0.5, ease }} />
      </div>

      <div className="relative mt-10 min-h-[420px] overflow-hidden">
        <AnimatePresence mode="wait" custom={dir} initial={false}>
          <motion.fieldset
            key={step}
            custom={dir}
            initial={{ opacity: 0, x: dir * 40 }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: dir * -40 }}
            transition={{ duration: 0.35, ease }}
          >
            <legend className="text-2xl font-extrabold leading-snug tracking-tight text-fg md:text-[1.75rem]">{q.q}</legend>
            <p className="mt-2 text-muted">{q.context}</p>
            <div className="mt-7 grid gap-3">
              {q.options.map((o, i) => {
                const selected = answers[step] === i;
                return (
                  <button
                    key={o.text}
                    type="button"
                    onClick={() => choose(i)}
                    aria-pressed={selected}
                    className={`flex items-center gap-4 rounded-[16px] border px-5 py-4 text-left text-[16px] font-medium transition-[border-color,background-color,transform] duration-300 hover:-translate-y-0.5 active:scale-[0.99] ${
                      selected ? "border-accent bg-accent-soft text-fg" : "border-line bg-[var(--bg-elevated)]/60 text-fg hover:border-accent/60"
                    }`}
                  >
                    <span className={`grid size-7 shrink-0 place-items-center rounded-full border-2 text-xs font-bold ${selected ? "border-accent bg-accent text-white" : "border-line text-muted"}`}>
                      {String.fromCharCode(65 + i)}
                    </span>
                    {o.text}
                  </button>
                );
              })}
            </div>
          </motion.fieldset>
        </AnimatePresence>
      </div>

      <div className="mt-6 flex items-center justify-between">
        <button type="button" onClick={back} disabled={step === 0} className="inline-flex items-center gap-2 font-semibold text-muted transition-colors hover:text-fg disabled:invisible">
          <ArrowLeft size={16} weight="bold" /> Back
        </button>
        {answers[step] >= 0 && step < questions.length - 1 && (
          <button type="button" onClick={() => (setDir(1), setStep(step + 1))} className="inline-flex items-center gap-2 font-semibold text-fg">
            Next <ArrowRight size={16} weight="bold" />
          </button>
        )}
      </div>
    </div>
  );
}

function Results({ result, onRestart }: { result: ReturnType<typeof score>; onRestart: () => void }) {
  const r = 70;
  const c = 2 * Math.PI * r;
  return (
    <motion.div initial={{ opacity: 0, y: 16 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.6, ease }}>
      <div className="grid items-center gap-8 md:grid-cols-[auto_1fr]">
        <div className="relative mx-auto size-44">
          <svg viewBox="0 0 160 160" className="size-full -rotate-90" aria-hidden>
            <circle cx="80" cy="80" r={r} fill="none" stroke="var(--line)" strokeWidth="12" />
            <motion.circle
              cx="80" cy="80" r={r} fill="none" stroke="var(--accent)" strokeWidth="12" strokeLinecap="round"
              strokeDasharray={c}
              initial={{ strokeDashoffset: c }}
              animate={{ strokeDashoffset: c - (result.total / 100) * c }}
              transition={{ duration: 1.4, ease, delay: 0.2 }}
            />
          </svg>
          <div className="absolute inset-0 grid place-items-center text-center">
            <div>
              <p className="text-5xl font-extrabold tracking-[-0.04em] text-fg">{result.total}</p>
              <p className="text-xs font-bold text-muted">OUT OF 100</p>
            </div>
          </div>
        </div>
        <div>
          <h2 className="text-3xl font-extrabold tracking-tight text-fg">{result.verdict.headline}</h2>
          <p className="mt-3 max-w-xl leading-relaxed text-muted">{result.verdict.summary}</p>
        </div>
      </div>

      <div className="mt-10 grid gap-4 sm:grid-cols-2">
        {dimensions.map((d, i) => (
          <div key={d} className="rounded-[18px] border border-line bg-[var(--bg-elevated)]/60 p-6">
            <div className="flex items-baseline justify-between gap-3">
              <h3 className="font-bold text-fg">{d}</h3>
              <p className="text-2xl font-extrabold text-fg">
                {result.dims[i]}
                <span className="text-sm font-semibold text-muted">/25</span>
              </p>
            </div>
            <motion.div
              className="mt-3 h-1.5 rounded-full bg-accent"
              initial={{ width: 0 }}
              animate={{ width: `${(result.dims[i] / 25) * 100}%` }}
              transition={{ duration: 1, ease, delay: 0.3 + i * 0.1 }}
            />
            <p className="mt-4 text-[15px] leading-relaxed text-muted">{result.recs[i]}</p>
          </div>
        ))}
      </div>

      <div className="mt-10 rounded-[var(--radius-card)] bg-accent-soft p-7">
        <h3 className="text-xl font-extrabold text-fg">Want a deeper analysis?</h3>
        <p className="mt-2 max-w-xl leading-relaxed text-muted">
          Book a 30-minute session with our AI advisory team. We&apos;ll walk through your results and identify the highest-impact starting point.
        </p>
        <div className="mt-6 flex flex-wrap items-center gap-4">
          <Button href={ctas.primary.href}>{ctas.primary.label}</Button>
          <button type="button" onClick={onRestart} className="inline-flex items-center gap-2 font-semibold text-muted hover:text-fg">
            <ArrowCounterClockwise size={16} weight="bold" /> Retake
          </button>
        </div>
      </div>
    </motion.div>
  );
}
