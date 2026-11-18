import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  images: {
    remotePatterns: [{ protocol: "https", hostname: "descasio.io", pathname: "/wp-content/uploads/**" }],
  },
  // The live site uses trailing slashes; keep old links working.
  trailingSlash: true,
};

export default nextConfig;
