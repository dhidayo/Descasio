import { Button } from "./Button";

export function AssessmentPromo() {
  return (
    <div className="relative overflow-hidden rounded-[var(--radius-card)] bg-accent-strong p-7 text-white">
      <p className="text-sm font-bold text-white/80">Free</p>
      <h3 className="mt-2 text-2xl font-extrabold tracking-tight">AI Readiness Assessment</h3>
      <p className="mt-2 leading-relaxed text-white/85">
        Take our self-assessment to understand where your organisation stands on AI readiness.
      </p>
      <Button href="/ai-readiness" variant="glass" className="mt-6 !text-white">
        Start Assessment
      </Button>
    </div>
  );
}
