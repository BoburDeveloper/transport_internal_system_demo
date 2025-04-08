import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  server: {
      host: 'localhost',    // Bind to localhost (or 0.0.0.0 for external access)
      port: 5173,           // Ensure the port is correct
      strictPort: true,            // Ensure Vite doesn't choose a different port
  },
  publicDir: 'vite',
  build: {
    outDir: 'public/build',
	manifest: true, // ensure manifest is generated
    assetsDir: 'assets',
      rollupOptions: {
          input: 'resources/js/app.jsx', // Correct entry point (your main JS file)
      },
  }
});
