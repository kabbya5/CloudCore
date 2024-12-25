// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },

  css:[
    '~/assets/sass/_app.scss',
  ],
  runtimeConfig: {
    public: {
      baseURL: 'http://localhost:8000', 
    },
  },
  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  modules: [
    '@pinia/nuxt',
    '@nuxt/image',
  ]
})