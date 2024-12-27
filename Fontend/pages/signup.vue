<template>
    <div class="min-h-screen bg-gray-100 flex justify-center items-center">
      <div id="authentication-form" class="bg-white shadow-2xl rounded-lg p-8 w-full max-w-lg">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <h2 class="text-3xl font-extrabold text-gray-500 hover:text-blue-600 transition-colors duration-300">
                CloudCore
            </h2>
        </div>
  
        <!-- Form -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Sign Up</h2>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="first-name" class="block text-gray-700 font-medium">First Name</label>
                <input 
                    id="first-name" 
                    type="text" 
                    v-model="form.first_name" 
                    :class="{'border-red-500': errors.first_name}" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your first name"
                >
                <p v-if="errors.first_name" class="text-red-500 text-sm">{{ errors.first_name }}</p>
            </div>

            <div>
                <label for="last-name" class="block text-gray-700 font-medium">Last Name</label>
                <input 
                    id="last-name" 
                    type="text" 
                    v-model="form.last_name" 
                    :class="{'border-red-500': errors.last_name}" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your last name"
                >
                <p v-if="errors.last_name" class="text-red-500 text-sm">{{ errors.last_name }}</p>
            </div>

            <div>
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    v-model="form.email" 
                    :class="{'border-red-500': errors.email}" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your email"
                >
                <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-medium">Phone Number</label>
                <input 
                    id="phone" 
                    type="tel" 
                    v-model="form.phone" 
                    :class="{'border-red-500': errors.phone}" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your phone number"
                >
                <p v-if="errors.phone" class="text-red-500 text-sm">{{ errors.phone }}</p>
            </div>

            <div>
                <label class="block text-gray-700 font-medium">Gender</label>
                <div class="flex gap-4 mt-2">
                    <label class="flex items-center">
                    <input type="radio" name="gender" value="male" v-model="form.gender" class="mr-2" />
                    Male
                    </label>
                    <label class="flex items-center">
                    <input type="radio" name="gender" value="female" v-model="form.gender" class="mr-2" />
                    Female
                    </label>
                    <label class="flex items-center">
                    <input type="radio" name="gender" value="other" v-model="form.gender" class="mr-2" />
                    Other
                    </label>
                </div>
                <p v-if="errors.gender" class="text-red-500 text-sm">{{ errors.gender }}</p>
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-medium"> Password </label>
                <input 
                    id="phone" 
                    type="password" 
                    v-model="form.password" 
                    :class="{'border-red-500': errors.phone}" 
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your phone number"
                >
                <p v-if="errors.phone" class="text-red-500 text-sm">{{ errors.phone }}</p>
            </div>

            <div>
                <label for="phone" class="block text-gray-700 font-medium"> Confirm Password </label>
                <input 
                    id="phone" 
                    type="password" 
                    v-model="form.password_confirmation" 
                    :class="{'border-red-500': errors.phone}" 
                    class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter your phone number"
                >
                <p v-if="errors.phone" class="text-red-500 text-sm">{{ errors.phone }}</p>
            </div>

            <div class="text-center">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">Sign Up</button>
            </div>

            <div class="text-center text-gray-600">
                <p>Already have an account? <NuxtLink to="/login" class="text-blue-600">Login here</NuxtLink></p>
            </div>
        </form>
      </div>
    </div>
</template>
  
<script setup lang="ts">
import { useAuthStore } from '~/stores/auth';
import type { AuthenticationForm } from '~/types/form';

const  authStore = useAuthStore();
const router = useRouter();

definePageMeta({
    middleware: 'auth'
});

const form = ref<AuthenticationForm>({
    first_name: 'md',
    last_name: 'kabbya',
    email: 'kabbya7@gmail.com',
    phone: '+8801721597157',
    gender: 'male',
    password: 'Str0ng@Pass12',
    password_confirmation: 'Str0ng@Pass12'
});

const errors = ({});

const submitForm = async () => {
    await authStore.singUp(form);
};
</script>
