import { defineNuxtRouteMiddleware, navigateTo } from 'nuxt/app';
import { useAuthenticationStore } from '~/stores/authentication';

export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthenticationStore();
  const token = authStore.getToken();


  if (process.client) {
    if (!token && to.path !== '/login' && to.path !== '/signup') {
      return navigateTo('/login');
    }

    
    if (token && (to.path === '/login' || to.path === '/signup')) {
        return navigateTo('/');
    }
  }
});