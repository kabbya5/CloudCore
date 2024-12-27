<template>
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="text-left mb-2 text-black text-semibold text-xl"> The Progressive Task </h2>
            <NuxtLink to="/tasks" class="text-black underline"> View All </NuxtLink>
        </div>
           
        <Tasks />
    </div>
   
</template>

<script setup lang="ts">

import { useTasksStore } from '~/stores/task';
const taskStore = useTasksStore();

const tasks = taskStore.tasks;

definePageMeta({
    middleware: 'auth',
});

useHead({
    title:'Cloud Core',
})

const handleScroll = () => {
    if (window.innerHeight + window.scrollY >= document.body.scrollHeight) {
        if (!taskStore.loading && taskStore.hasMore) {
            taskStore.fetchTasks();
        }
    }
};
onMounted(async () => {
    taskStore.fetchTasks();
    window.addEventListener('scroll', handleScroll); 
});


onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll); 
});
</script>