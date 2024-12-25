<template>
    <div class="flex justify-center items-center h-full w-full">
        <div id="authentication-form" class="w-full max-w-[600px] shadow-xl p-6 rounded-lg">
            <div class="flex justify-center items-center mb-6">
                <h2 class="text-2xl font-medium text-dark">Login</h2>
            </div>
            <form @submit.prevent="handleLogin">
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        v-model="loginForm.email" 
                        required 
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        v-model="loginForm.password" 
                        required 
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"
                    />
                </div>
                <div class="flex justify-center">
                    <button 
                        type="submit" 
                        class="w-full py-2 px-4 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-200"
                    >
                        Login
                    </button>
                </div>
                <div class="text-center">
                <p class="mb-4">Already have an account?</p>
                <NuxtLink to="/signup" class="text-blue-600 hover:underline">Sign up here</NuxtLink>
            </div>
            </form>
        </div>
    </div>
</template>

<script setup lang="ts">

definePageMeta({
    middleware: 'auth'
});

import { useAuthStore } from '~/stores/auth';
const errors = ref('');
const apiUrl = getBaseUrl();
const authStore = useAuthStore();
const router = useRouter();

interface loginType{
    email:string,
    password:string,
}

const loginForm = ref<loginType>({
    email:'kabbya7@gmail.com',
    password:'Str0ng@Pass12',
});



const handleLogin = async() =>{
    authStore.login(loginForm);
    router.push('/');
}

</script>

<style scoped>
/* Add any additional styles here */
</style>