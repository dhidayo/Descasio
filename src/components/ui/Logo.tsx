import Image from "next/image";

/** Wordmark that swaps between the ink and white versions with the theme. */
export function Logo({ className = "h-7 w-auto" }: { className?: string }) {
  return (
    <>
      <Image src="/brand/descasio-logo-light-bg.png" alt="Descasio" width={249} height={68} priority className={`${className} dark:hidden`} />
      <Image src="/brand/descasio-logo-dark-bg.png" alt="Descasio" width={249} height={68} priority className={`${className} hidden dark:block`} />
    </>
  );
}
