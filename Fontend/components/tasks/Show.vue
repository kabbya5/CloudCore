<template>
    <div 
        v-if="isVisible" 
        class="modal-overlay"
        @click.self="closeModal"  
    >
      <div class="modal-content">
            <h2 class="font-xl mb-3 text-xl"> Create Task </h2>
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <p class="mt-1 block w-full px-3 py-2 shadow-sm"> {{ task.title }} </p>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700"> Assign To </label>
                <select
                    required
                    v-model="localTask.assigned_to"
                    type="text" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"           
                >
                    <option value="" selected disabled>  Select </option>
                    <option v-for="user in users" value="user.id"> {{ user.name }} </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select
                    v-model="localTask.status"
                    type="text" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                >
                    <option value="pending"> Pending </option>
                    <option value="progress"> Progress </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                <select
                    v-model="localTask.priority"
                    type="text" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"           
                >
                    <option value="high"> High</option>
                    <option value="medium"> Medium </option>
                    <option value="low"> Low </option>
                </select>
            </div>

            <div class="mb-4">
                <label  class="block text-sm font-medium text-gray-700">Due Date</label>
                <input 
                    v-model="localTask.due_date"
                    type="date" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                />
            </div>

            <div class="mb-4">
                <label  class="block text-sm font-medium text-gray-700"> Description </label>
                <textarea
                    v-model="localTask.description"
                    
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm"
                >
                </textarea>
            </div>

      </div>
    </div>
</template>
  
<script setup lang="ts">

const props = defineProps({
    task:Object,
})
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
  