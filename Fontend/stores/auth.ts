import {defineStore} from 'pinia';
import { useAuthenticationStore } from './authentication';
import type { AuthenticationForm } from '~/types/form';
import { useRouter } from 'nuxt/app';
export const useAuthStore = defineStore('user', {
    state:() =>({
        user:[] as any[],
        loading:false,
        isClient: process.client, 
    }),

    actions:{
        async singUp(form:AuthenticationForm){
            this.loading = true;
            try{
                const response = await useCustomFetch(`/signup`,{
                    method: 'POST',
                    body: form as AuthenticationForm,
                });
                const user = response.value.user;
                if(user){
                    const router = useRouter()
                    router.push(`/verify-code/${user.id}`);
                }
                        
            }catch (error: any) {
                console.log('Error during sign-up:', error);
                if (error.response) {
                    console.log('Response error:', error.response);  // Log any response-related error details
                } else {
                    console.log('Unknown error:', error);  // Handle unknown errors
                }  
            }finally{
                this.loading = false;
            }
        },

        async login(form: AuthenticationForm) {
            this.loading = true;
            try {
                const response = await useCustomFetch(`/login`, {
                    method: 'POST',
                    body: form as AuthenticationForm,
                });

                const user = response.value.user;
                if(user){
                    const router = useRouter()
                    router.push(`/verify-code/${user.id}`);
                }
      
            } catch (error: any) {
                console.log('Login error:', error);
            } finally {
                this.loading = false;
            }
        },
      
        async logout() {
            this.loading = true;
            try {
                await useCustomFetch(`/logout`, {
                    method: 'POST',
                });
      
                const {clearAuthData} = useAuthenticationStore();  
                clearAuthData();
            } catch (error: any) {
                 console.log('Logout error:', error);
            } finally {
                this.loading = false;
            }
        },
    }
})