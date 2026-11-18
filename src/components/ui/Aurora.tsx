/** Fixed ambient light behind the page, in the logo's vermilion plus a cool counter-tone. Gives the glass something to refract. */
export function Aurora() {
  return (
    <div aria-hidden className="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-bg transition-colors duration-500">
      <div className="drift absolute -top-[18%] right-[-12%] h-[60vmax] w-[60vmax] rounded-full bg-[radial-gradient(circle,var(--blob-a),transparent_62%)] blur-3xl" />
      <div
        className="drift absolute top-[30%] -left-[18%] h-[58vmax] w-[58vmax] rounded-full bg-[radial-gradient(circle,var(--blob-b),transparent_62%)] blur-3xl"
        style={{ animationDelay: "-9s" }}
      />
      <div
        className="drift absolute -bottom-[25%] right-[10%] h-[50vmax] w-[50vmax] rounded-full bg-[radial-gradient(circle,var(--blob-c),transparent_62%)] blur-3xl"
        style={{ animationDelay: "-16s" }}
      />
    </div>
  );
}
