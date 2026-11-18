import type { Metadata, Viewport } from "next";
import localFont from "next/font/local";
import "./globals.css";
import { Nav } from "@/components/layout/Nav";
import { Footer } from "@/components/layout/Footer";
import { SmoothScroll } from "@/components/layout/SmoothScroll";
import { themeScript } from "@/components/layout/ThemeToggle";
import { Aurora } from "@/components/ui/Aurora";
import { Providers } from "@/components/layout/Providers";

// Plus Jakarta Sans (SIL Open Font Licence), self-hosted variable font, weights 200-800.
const jakarta = localFont({
  src: "./fonts/PlusJakartaSans-Variable.woff2",
  weight: "200 800",
  variable: "--font-jakarta",
  display: "swap",
});

export const metadata: Metadata = {
  metadataBase: new URL(process.env.NEXT_PUBLIC_SITE_URL ?? "https://descasio.io"),
  title: { default: "Descasio | Cloud, Automation and AI for African Enterprise", template: "%s | Descasio" },
  description:
    "Africa's Intelligent Enterprise Platform. We build the cloud, automate the workflows, and transform the enterprise. Built in Nigeria. Owned end to end.",
  openGraph: { siteName: "Descasio", type: "website", locale: "en_GB" },
  // Pages carry "noindex" until ALLOW_INDEXING=true is set on the live domain.
  robots: process.env.ALLOW_INDEXING === "true" ? undefined : { index: false, follow: false },
};

export const viewport: Viewport = {
  themeColor: [
    { media: "(prefers-color-scheme: light)", color: "#f6f7fa" },
    { media: "(prefers-color-scheme: dark)", color: "#0a1220" },
  ],
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en-GB" className={jakarta.variable} suppressHydrationWarning>
      <head>
        <script dangerouslySetInnerHTML={{ __html: themeScript }} />
      </head>
      <body>
        <a href="#main" className="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-full focus:bg-accent-strong focus:px-4 focus:py-2 focus:text-white">
          Skip to content
        </a>
        <Providers>
          <Aurora />
          <SmoothScroll />
          <Nav />
          <main id="main">{children}</main>
          <Footer />
        </Providers>
      </body>
    </html>
  );
}
