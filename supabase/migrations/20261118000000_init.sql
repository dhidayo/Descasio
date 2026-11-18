-- Descasio website: lead capture tables.
-- Rows are written only by the Next.js server (service role key). RLS is on with no
-- public policies, so the anon key can neither read nor write these tables.

create table if not exists public.contact_requests (
  id          uuid primary key default gen_random_uuid(),
  created_at  timestamptz not null default now(),
  first_name  text not null check (char_length(first_name) between 1 and 100),
  last_name   text not null check (char_length(last_name) between 1 and 100),
  email       text not null check (char_length(email) between 3 and 254),
  company     text not null check (char_length(company) between 1 and 200),
  topic       text not null check (topic in ('general', 'cloud', 'ai-advisory', 'plugiq', 'partnership')),
  message     text not null check (char_length(message) between 1 and 5000),
  source_path text
);

create table if not exists public.readiness_results (
  id           uuid primary key default gen_random_uuid(),
  created_at   timestamptz not null default now(),
  first_name   text not null,
  last_name    text not null,
  email        text not null,
  company      text not null,
  job_title    text,
  company_size text check (company_size in ('1-50', '51-200', '201-1000', '1000+')),
  answers      smallint[] not null check (array_length(answers, 1) = 12),
  total_score  smallint not null check (total_score between 0 and 100),
  dim_scores   smallint[] not null check (array_length(dim_scores, 1) = 4)
);

alter table public.contact_requests  enable row level security;
alter table public.readiness_results enable row level security;

create index if not exists contact_requests_created_at_idx  on public.contact_requests (created_at desc);
create index if not exists readiness_results_created_at_idx on public.readiness_results (created_at desc);
