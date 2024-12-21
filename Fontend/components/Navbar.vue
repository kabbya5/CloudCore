<template>
<nav class="bg-blue-600 p-4">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    <!-- Logo  -->
    <div class="text-white text-2xl font-semibold">
       <NuxtLink to="/"> TaskManager</NuxtLink>
    </div> 

    <Nuxtlike href="/tasks" class="text-white hover:text-gray-300">Tasks</Nuxtlike>

    <div class="flex space-x-4">

    

      <div class="flex space-x-4 ">
        <!-- <a href="#" class="border border-1 border-whiet text-white hover:bg-white hover:text-blue-800 transation duration-300 px-4 py-2 rounded"> Login </a> -->
        <NuxtLink :to="{name:'signup'}" class="border border-1 border-white text-white hover:bg-white hover:text-blue-800 transition duration-300 px-4 py-2 rounded">
            Signup
        </NuxtLink>
      </div>
    </div>
  </div>
</nav>

</template>
