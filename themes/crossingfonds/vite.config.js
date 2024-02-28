import { defineConfig } from "vite";
import { resolve } from "path";
import react from "@vitejs/plugin-react";
import tsconfigPaths from "vite-tsconfig-paths";

// https://vitejs.dev/config/
export default defineConfig({
  resolve: {
    alias: {
      react: "preact/compat",
    },
  },
  esbuild: {
    jsxFactory: "h",
    jsxFragment: "PFrag",
    jsxInject: `import { h, Fragment as PFrag } from 'preact'`,
  },
  build: {
    sourcemap: true,
    outDir: `asset/js`,
    emptyOutDir: false,
    lib: {
      entry: "src/clover.jsx",
      formats: ["umd"],
      name: "CloverIIIFWC",
      fileName: () => {
        return `clover.umd.js`;
      },
    },
    minify: "esbuild",
    plugins: [],
    rollupOptions: {
      treeshake: true,
      external: [],
      output: {
        globals: {},
        inlineDynamicImports: true,
      },
    },
  },
  define: { "process.env.NODE_ENV": '"production"' },
  plugins: [tsconfigPaths()],
});
