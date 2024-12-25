<template>
<nav class="bg-white p-4 shadow-xl border-2 border-b border-gray-300">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    <!-- Logo  -->
    <div class="text-white text-2xl font-semibold">
      <NuxtLink to="/">
        <NuxtImg class="h-10 text-white" src="/images/logo.png" alt="cloud core" />
      </NuxtLink>
    </div> 

    <NuxtLink href="/tasks" class="text-black hover:text-gray-700">Tasks</NuxtLink>

    <div class="flex space-x-4">

      <div v-if="token" class="relative">
        <div @click="toggleDropdown" class="flex items-center cursor-pointer">

          <NuxtImg
            v-if="user.profile_image"
            src="authData.user.profile_picture"
            alt="Profile"
            class="w-10 h-10 rounded-full"
          />

          <NuxtImg
            v-else
            src="/images/icon/user.png"
            alt="Profile"
            class="w-10 h-10 rounded-full"
          />
          
        </div>

        <div v-if="showDropDown"
          class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg">
          <ul class="py-2">
            <li
              
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
            >
              Profile
            </li>
            <button @click="handelLogout"
              class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
            >
              Logout
            </button>
          </ul>
        </div>
      </div>

      <div v-else class="flex space-x-4 ">
        <a href="#" class="border border-1 border-whiet text-white bg-blue-800 hover:bg-blue-700 hover:text-slate-200 transation duration-300 px-4 py-2 rounded"> Login </a>
        <NuxtLink :to="{name:'signup'}" class="border border-1 border-white text-white bg-blue-800 hover:bg-blue-700 hover:text-slate-200  transition duration-300 px-4 py-2 rounded">
            Signup
        </NuxtLink>
      </div>
    </div>
  </div>
</nav>

</template>

<script setup lang="ts">
import { useAuthenticationStore } from '~/stores/authentication';
import { useAuthStore } from '~/stores/auth';

const  authStore = useAuthStore();
const {getToken, getUser} = useAuthenticationStore();
const router = useRouter();

const user = ref(null);
const token = ref(null);
const showDropDown = ref(false);

function toggleDropdown() {
  showDropDown.value = !showDropDown.value;
}

onMounted(async () => {
  user.value =  getUser();
  token.value = getToken();
});

const handelLogout = async() =>{
  authStore.logout();
  router.push('/');
};


</script>
