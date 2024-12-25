<template>
    <div 
        v-if="isVisible" 
        class="modal-overlay"
        @click.self="closeModal"  
    >
      <div class="modal-content">

            <h2 class="font-xl mb-3 text-xl"> Create Task </h2>

            <form @submit.prevent="handleSubmit">
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input 
                        v-model="task.title"
                        type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Enter title"
                    />
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select
                        v-model="task.status"
                        type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    >
                      <option value="pending"> Pending </option>
                      <option value="procesing"> Procesing </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select
                        v-model="task.priority"
                        type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"           
                    >
                      <option value="high"> High</option>
                      <option value="medium"> Medium </option>
                      <option value="low"> Low </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label  class="block text-sm font-medium text-gray-700">Due Date</label>
                    <input 
                        v-model="task.due_date"
                        type="date" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    />
                </div>

                <div class="mb-4">
                    <label  class="block text-sm font-medium text-gray-700"> Details </label>
                    <textarea
                        v-model="task.description"
                        
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    </textarea>
                </div>

                <button 
                  type="submit" 
                  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                  {{ isEditMode ? 'Update Task' : 'Create Task' }}
                </button>
            </form>
      </div>
    </div>
</template>
  
<script setup lang="ts">

const props = defineProps({
    isVisible:Boolean,
    isEditMode:Boolean,
    task:Object,
})
 
const localTask = ref({ ...props.task });
const emit = defineEmits(['update:isVisible', 'submitTask']);

const handleSubmit = () => {
  emit('submitTask', localTask.value);   
};


const closeModal = () => {
  emit('update:isVisible', false);
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
  
  .form-group {
    margin-bottom: 15px;
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
  