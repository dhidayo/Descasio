import { Hero } from "@/components/home/Hero";
import { Stats } from "@/components/home/Stats";
import { LogoMarquee } from "@/components/home/LogoMarquee";
import { Layers } from "@/components/home/Layers";
import { WhyBento } from "@/components/home/WhyBento";
import { Results } from "@/components/home/Results";
import { CtaBand } from "@/components/ui/CtaBand";

export default function Home() {
  return (
    <>
      <Hero />
      <Stats />
      <LogoMarquee />
      <Layers />
      <WhyBento />
      <Results />
      <CtaBand />
    </>
  );
}
