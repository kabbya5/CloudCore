<template>
    <div 
        v-if="task && task.title" 
        class="modal-overlay"
        @click.self="closeModal"  
    >
      <div class="modal-content">
            <button class="close-button" @click="closeModal">×</button>
            <h2 class="font-xl mb-3 text-2xl">Task Details</h2>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm text-xl"> 
                    {{ task.title }} 
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm text-xl"> 
                    {{ formatDate(task.due_date) }} 
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm text-xl"> 
                    {{ task.status }} 
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Priority</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm text-xl"> 
                    {{ task.priority }} 
                </p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Details</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm text-xl"> 
                    {{ task.description }} 
                </p>
            </div>
      </div>
    </div>
</template>
  
<script setup lang="ts">
const props = defineProps({
    task: Object,
});
const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>
  
<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}
  
.modal-content {
    background: white;
    padding: 20px;
    width: 400px;
    border-radius: 10px;
    position: relative;
}
  
.close-button {
    position: absolute;
    top: 10px;
    right: 10px;
    border: none;
    background: none;
    font-size: 20px;
    cursor: pointer;
}
  
button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}
  
button[type="submit"] {
    width: 100%;
}
</style>
