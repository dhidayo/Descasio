// Copies Phosphor icon fonts (woff2 only) and Lenis into the theme so WordPress needs no build step.
import { copyFileSync, mkdirSync, readFileSync, writeFileSync, rmSync } from "node:fs";
const dest = "descasio-theme/assets/vendor";
rmSync(`${dest}/phosphor`, { recursive: true, force: true });
const names = { duotone: "Duotone", bold: "Bold", fill: "Fill" };
for (const [weight, name] of Object.entries(names)) {
  const src = `node_modules/@phosphor-icons/web/src/${weight}`;
  const out = `${dest}/phosphor/${weight}`;
  mkdirSync(out, { recursive: true });
  copyFileSync(`${src}/Phosphor-${name}.woff2`, `${out}/Phosphor-${name}.woff2`);
  // Point @font-face at the woff2 file only and add font-display: swap.
  const css = readFileSync(`${src}/style.css`, "utf8").replace(
    /src:[\s\S]*?;/,
    `src: url("./Phosphor-${name}.woff2") format("woff2");`,
  ).replace("font-display: block;", "font-display: swap;"
  );
  writeFileSync(`${out}/style.css`, css);
}
mkdirSync(`${dest}/lenis`, { recursive: true });
copyFileSync("node_modules/lenis/dist/lenis.min.js", `${dest}/lenis/lenis.min.js`);
copyFileSync("node_modules/lenis/dist/lenis.css", `${dest}/lenis/lenis.css`);
console.log("vendor assets copied");
