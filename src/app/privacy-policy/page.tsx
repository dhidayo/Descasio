import type { Metadata } from "next";
import privacy from "@/content/privacy.json";
import { PageHero } from "@/components/ui/PageHero";

export const metadata: Metadata = { title: "Privacy Policy", description: "How Descasio collects, uses, discloses, and safeguards your information." };

type Block = { t: "h2" | "h3" | "p"; text: string; label?: string };

// Legal copy is reproduced verbatim from descasio.io/privacy-policy. Do not edit without legal approval.
export default function PrivacyPolicy() {
  return (
    <>
      <PageHero label="Legal" title="Privacy Policy" intro={privacy.meta} />
      <section className="mx-auto max-w-3xl px-4 pb-8">
        <div className="glass prose-descasio rounded-[28px] p-7 md:p-12">
          {(privacy.blocks as Block[]).map((b, i) =>
            b.t === "h2" ? (
              <h2 key={i} className="first:mt-0">{b.text}</h2>
            ) : b.t === "h3" ? (
              <h3 key={i}>{b.text}</h3>
            ) : (
              <p key={i}>
                {b.label && <strong className="text-fg">{b.label} </strong>}
                {b.text}
              </p>
            ),
          )}
        </div>
      </section>
    </>
  );
}
