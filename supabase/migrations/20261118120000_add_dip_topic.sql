-- Allow "dip" (Decision Intelligence Platform) as a contact topic.
alter table public.contact_requests drop constraint if exists contact_requests_topic_check;
alter table public.contact_requests
  add constraint contact_requests_topic_check
  check (topic in ('general', 'dip', 'cloud', 'ai-advisory', 'plugiq', 'partnership'));
