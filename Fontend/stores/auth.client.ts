import {defineStore} from 'pinia';
import { useAuthentication } from './authentication.client';
import { AuthenticationForm } from '~/types/form';

export const useAuthStore = defineStore('user', {
    state:() =>({
        user:[] as any[],
        loading:false,
    }),

    actions:{
        async singUp(form:AuthenticationForm){
            this.loading = true;
            const baseUrl = await getBaseUrl();
            try{
                const response = await fetch(`${baseUrl}/signup`,{
                    method:'POST',
                    headers: {
                        'Content-Type': 'application/json', 
                    },
                    body: JSON.stringify(form),
                });
            }catch(err){
                alert('Error');
            }finally{
                this.loading = false;
            }
        }
    }
})