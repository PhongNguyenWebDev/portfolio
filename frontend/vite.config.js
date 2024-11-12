import { fileURLToPath, URL } from "node:url";
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./src", import.meta.url)),
    },
  },
  build: {
    target: "esnext",
    rollupOptions: {
      output: {
        manualChunks(id) {
          if (id.includes("node_modules")) {
            if (id.includes("lodash")) {
              return "lodash"; // Tạo một chunk riêng cho lodash
            }
            if (id.includes("vue")) {
              return "vue"; // Tạo một chunk riêng cho Vue
            }
            return "vendor"; // Các thư viện còn lại vẫn vào vendor
          }
        },
      },
    },
    chunkSizeWarningLimit: 2000, // Tăng giới hạn kích thước chunk warning lên 2MB
  },
});
