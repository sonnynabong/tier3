// @ts-check
import { defineConfig } from 'astro/config';

import sitemap from '@astrojs/sitemap';

export default defineConfig({
  site: 'https://tier3media.com',
  output: 'static',
  integrations: [sitemap()],
});