<template>
    <TasksCreate :isVisible="isVisible" @update:isVisible="isVisible = $event"
         :isEditMode="isEditMode" :task="task" 
         @submitTask="handleTaskSubmit" />

    <div class="container mx-auto px-4">
        <div class="shadow-md rounded-xl p-6 mb-8 border border-gray-300">
            <div class="flex flex-wrap justify-between items-center mb-6 space-y-4 md:space-y-0">
                <h1 class="text-3xl font-bold text-gray-900">Tasks</h1>
                <div class="flex space-x-4">
                    <button 
                    @click="addTask"
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition"
                    >
                    + Add Task
                    </button>
                    
                    <button 
                    @click="resetFilters"
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition"
                    >
                    Reset
                    </button>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input 
                    type="text" 
                    v-model="searchInput.search_query"
                    @input="filterTasks"
                    placeholder="Search tasks..." 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
            <div>
                <select 
                v-model="searchInput.status"
                @change="filterTasks"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="progress">progress</option>
                <option value="completed">Completed</option>
                </select>
            </div>
    
            <div>
                <select 
                v-model="searchInput.periority"
                @change="filterTasks"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <option value="">All Priority</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
                </select>
            </div>

            <div>
                <select 
                v-model="searchInput.order_by"
                @change="filterTasks"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value=""> Default </option>
                    <option value="due_date-DESC"> Due Date (DESC) </option>
                    <option value="status-ASC"> Status (ASC) </option>
                    <option value="status-DESC"> Status (DESC) </option>
                    <option value="priority-DESC"> Prority (DESC)  </option>
                    <option value="priority-DSC"> Priority (ASC) </option>
                    
                
                </select>
            </div>
    
            <div>
                <input 
                type="date" 
                 v-model="searchInput.due_date"
                @change="filterTasks"
                class="px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            </div>

        </div>
        <div>
            <Tasks />
        </div>
        
    </div>
  </template>

  <script setup lang="ts"> 
    import { useTasksStore } from '~/stores/task';
    const tasksStore = useTasksStore();
    interface SearchForm {
        search_query:string,
        status:string,
        periority:string,
        order_by:string,
        due_date:string,
    }

    const searchInput = ref<SearchForm>({
        search_query:'',
        status:'',
        periority:'',
        order_by:'',
        due_date:'',
    });

    const isVisible = ref(false); 
    const isEditMode = ref(false);
   
    const task = ref({
        title: '',
        status:'pending',
        priority:'high',
        description: '',
        due_date: '',
        assigned_to:null,
    });

    const addTask = () =>{
        isVisible.value = !isVisible.value;
    }

    const handleTaskSubmit = async (updatedTask :any) => {
        const response = await tasksStore.store(updatedTask);
        if(response == 'success'){
            isVisible.value = false;  
        } 
    };

    const handleScroll = () => {
        if (window.innerHeight + window.scrollY >= document.body.scrollHeight) {
            if (!tasksStore.loading && tasksStore.hasMore) {
                tasksStore.fetchTasks(
                    searchInput.value.status,
                    searchInput.value.periority,
                    searchInput.value.search_query,
                    searchInput.value.due_date,
                    searchInput.value.order_by,
                );
            }
        }
    };

    onMounted(async () => {
        tasksStore.fetchTasks(
            searchInput.value.status,
            searchInput.value.periority,
            searchInput.value.search_query,
            searchInput.value.due_date,
            searchInput.value.order_by,
        );
        window.addEventListener('scroll', handleScroll); 
    });

    onBeforeUnmount(() => {
        window.removeEventListener('scroll', handleScroll); 
    });

    const filterTasks = async () => {
        tasksStore.fetchTasks(
            searchInput.value.status,
            searchInput.value.periority,
            searchInput.value.search_query,
            searchInput.value.due_date,
            searchInput.value.order_by,
        );
    };
  </script>
  