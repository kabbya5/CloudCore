import { defineNuxtPlugin } from '#app';

export default defineNuxtPlugin(async (nuxtApp) => {
  const config = useRuntimeConfig();
  const baseURL = config.public.baseURL;

  const fetchCsrfToken = async () => {
    try {
      const { data, error } = await useFetch(`${baseURL}/csrf-token`, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest', 
            credentials: 'include', 
        }
      });

      if (error.value) {
        throw new Error(error.value.message);
      }

      console.log(data); 

      if (data?.csrf) {
        localStorage.setItem('csrf_token', data.csrf);
      } else {
        console.error('CSRF token not received');
      }
    } catch (error) {
      console.error('Error fetching CSRF token:', error);
    }
  };

 
  nuxtApp.hook('app:mounted', () => {
    fetchCsrfToken();
  });
});