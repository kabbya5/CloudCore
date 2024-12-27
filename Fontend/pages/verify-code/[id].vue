<template>
    <div class="flex justify-center min-h-screen bg-gray-100">
      <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-semibold text-center mb-6">Verify Your Email</h1>
        
        <form @submit.prevent="verifyCode">
          <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-700">Verification Code</label>
            <input 
              type="text" 
              id="code" 
              v-model="verificationCode"
              placeholder="Enter your code" 
              class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
  
          <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200"
            :disabled="loading"
          >
            <span v-if="loading">Verifying...</span>
            <span v-else>Verify</span>
          </button>
  
          <p v-if="errorMessage" class="text-red-500 text-sm mt-3">
            {{ errorMessage }}
          </p>
  
          <p class="text-sm text-gray-500 mt-6 text-center">
            Didn't receive a code? 
            <button @click="resendCode" type="button" class="text-blue-600 hover:underline">Resend</button>
          </p>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  
  const route = useRoute();
  const router = useRouter();
  const verificationCode = ref('');
  const loading = ref(false);
  const errorMessage = ref('');
  
  const verifyCode = async () => {
    loading.value = true;
    errorMessage.value = '';
  
    try {
      const response = await useCustomFetch(`verify-code/${route.params.id}`, {
        method: 'POST',
        body: JSON.stringify({ code: verificationCode.value }),
      });
  
      const token = response.value.token;
      const user = response.value.user;
  
      if(token) {
        const {setToken, setUser} = useAuthenticationStore();
        if(token){
            setToken(token);
            setUser(user);
        }
        router.push('/');  
      } else {
        errorMessage.value = data.message || 'Invalid verification code.';
      }
    } catch (error) {
      errorMessage.value = 'Something went wrong. Please try again.';
    } finally {
      loading.value = false;
    }
  };
  
  const resendCode = async () => {
    loading.value = true;
    errorMessage.value = '';
  
    try {
      await useCustomFetch(`/resend-code/${route.params.id}`, {
        method: 'POST'
      });
      alert('Verification code resent!');
    } catch (error) {
      errorMessage.value = 'Failed to resend code.';
    } finally {
      loading.value = false;
    }
  };
  </script>
  