# Descasio Website

The marketing website for Descasio: Africa's Intelligent Enterprise Platform. It is a modern rebuild of descasio.io with a frosted-glass design language, smooth motion, light and dark themes, and live content from the existing WordPress CMS.

## Tech stack

| Area | Choice |
| --- | --- |
| Framework | Next.js 15 (App Router, React 19, TypeScript) |
| Styling | Tailwind CSS v4 with CSS-variable design tokens |
| Motion | Motion (`motion/react`) and Lenis smooth scrolling |
| Icons | Phosphor Icons |
| Font | Plus Jakarta Sans, self-hosted variable font |
| Forms and leads | Next.js Server Actions, Zod validation, Supabase (Postgres) |
| Blog | Headless WordPress (descasio.io REST API), refreshed hourly |

## Getting started

```bash
npm install
cp .env.example .env.local   # then fill in the values
npm run dev
```

Open http://localhost:3000.

## Environment variables

| Variable | Purpose |
| --- | --- |
| `NEXT_PUBLIC_SITE_URL` | Canonical site URL for metadata, the sitemap and social cards |
| `SUPABASE_URL` | Supabase project URL (server only) |
| `SUPABASE_SERVICE_ROLE_KEY` | Supabase service role key (server only, never exposed to the browser) |
| `WORDPRESS_API_URL` | WordPress REST API base, defaults to `https://descasio.io/wp-json/wp/v2` |
| `ALLOW_INDEXING` | Set to `true` only on the live domain. Otherwise every page asks search engines not to index it. |

Without Supabase variables the site still runs. The contact form then asks visitors to email hi@descasio.io, and the AI Readiness Assessment still shows results.

## Database (Supabase)

The schema lives in `supabase/migrations`. It creates two tables:

- `contact_requests`: submissions from the contact form.
- `readiness_results`: AI Readiness Assessment leads, with answers and scores.

Row Level Security is enabled with no public policies, so only the server (using the service role key) can write or read. Apply the migration with the Supabase CLI (`supabase db push`) or paste the SQL into the Supabase SQL editor.

## Project structure

```
src/
  app/                  Routes (one folder per page)
    [slug]/             Service pages, plus WordPress posts at their original root URLs
    blog/               Blog index (WordPress)
    ai-readiness/       Interactive AI Readiness Assessment
    contact/            Contact form (Supabase)
  components/
    layout/             Navigation, footer, theme toggle, smooth scroll
    home/               Home page sections
    pages/              Shared page templates (service, post)
    forms/              Form fields, contact form, assessment
    ui/                 Buttons, glass cards, reveal animations, headings
  content/              All site copy (British English) and assessment data
  lib/                  Supabase client, server actions, WordPress client
supabase/migrations/    Database schema
public/                 Logo, client logos, team photos
```

## Design system

- **Colour:** taken from the logo. Vermilion `#E04A27` is the single accent, with `#C63B1C` used wherever white text sits on it (5.2:1 contrast). Ink navy `#0E1A2B` for text and a cool off-white background.
- **Themes:** light by default. Dark mode follows the visitor's system setting and can be switched with the toggle in the navigation.
- **Glass:** a `glass` utility in `src/app/globals.css` (`backdrop-filter` with layered borders), with a solid fallback for `prefers-reduced-transparency`.
- **Shape:** buttons are pills, cards use a 22px radius, form inputs 14px.
- **Motion:** content reveals on scroll, a pointer-driven parallax hero, spotlight cards and count-up statistics. All motion respects `prefers-reduced-motion`.

## SEO

Page URLs match the live site (including trailing slashes), so existing links and search rankings carry over. Blog posts keep their root-level URLs. A sitemap and robots.txt are generated automatically.

## Scripts

| Command | What it does |
| --- | --- |
| `npm run dev` | Start the development server |
| `npm run build` | Create a production build |
| `npm start` | Serve the production build |
| `npm run lint` | Run ESLint |

## Content notes

- The Backup & Disaster Recovery page has no copy on the live site yet. Placeholder text is marked `TODO(content)` in `src/content/services.ts`.
- Press items and whitepapers currently link to their pages on the live site. WordPress already exposes `press_item`, `whitepaper`, `case_study`, `event` and `job` types, so these can be moved onto the CMS next.
- The privacy policy is reproduced word for word from the live site and should only be changed with legal approval.

All rights reserved. © Descasio Technology.
