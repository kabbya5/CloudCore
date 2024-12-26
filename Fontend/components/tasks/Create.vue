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
                        v-model="localTask.title"
                        type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Enter title"
                    />
                </div>

                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium text-gray-700"> Assign To </label>
                    <select
                        required
                        v-model="localTask.assigned_to"
                        type="text" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"           
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
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
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
                        v-model="localTask.due_date"
                        type="date" 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    />
                </div>

                <div class="mb-4">
                    <label  class="block text-sm font-medium text-gray-700"> Description </label>
                    <textarea
                        v-model="localTask.description"
                        
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
import { useNotificationsStore } from '~/stores/notifications';
const notification = useNotificationsStore();
const router = useRouter();
const props = defineProps({
    isVisible:Boolean,
    isEditMode:Boolean,
    task:Object,
})

const users = ref<any|null>();

const localTask = ref({ ...props.task });
const emit = defineEmits(['update:isVisible', 'submitTask']);

const handleSubmit = () => {
  emit('submitTask', localTask.value);   
};

onMounted(async () => {
  try{
    const data = await useCustomFetch('/users');
    if(data.value){
      users.value = data.value.users;
    }else{
      console.log(data.value);
      throw new Error(`Fetch error: unable to fetch users`);
    }
  }catch(error){
    notification.addNotification('Users fetch problem. Store some fack users', 'warning');
    router.push('/');
  }
});

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
  