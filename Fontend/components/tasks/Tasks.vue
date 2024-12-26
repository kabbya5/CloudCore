<template>
     <TasksCreate 
        :isVisible="isVisible"
        @update:isVisible="isVisible = $event"
        :isEditMode="isEditMode"
        :task="currentTask"
        @submitTask="handleTaskSubmit"
    />

    <TasksView />

    <div class="relative flex flex-col w-full h-full overflow-auto text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
        <table class="w-full text-left table-auto min-w-max text-slate-800">
            <thead>
                <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Task
                        </p>
                    </th>
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Assigned to
                        </p>
                    </th>
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Due Date
                        </p>
                    </th>
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Priority
                        </p>
                    </th>
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Status
                        </p>
                    </th>
                    <th class="p-2">
                        <p class="text-xl leading-none font-md text-black">
                            Action
                        </p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in taskStore.tasks" class="hover:bg-slate-50">
                    <td class="p-2">
                    <p class="text-sm">
                        {{ task.title }}
                    </p>
                    </td>
                    <td class="p-2">
                    <p class="text-sm">
                        {{ task.first_name + ' ' + task.last_name }}
                    </p>
                    </td>
                    <td class="p-2">
                    <p class="text-sm">
                        {{ getFormattedDate(task.due_date) }}
                    </p>
                    </td>
                    <td class="p-2">
                    <p class="text-sm">
                        {{ task.priority }}
                    </p>
                    </td>
                    <td class="p-2">
                    <p class="text-sm">
                        {{ task.status }}
                    </p>
                    </td>
                    <td class="border px-4 py-2 relative">
                        <div class="relative inline-block text-left">
                            <button @click="toggleDropdown(task.id)" class="bg-blue-500 text-white px-4 py-1 rounded">
                                Actions
                            </button>
                            <div
                            v-if="dropdownOpen === task.id"
                            class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-50"
                            >
                            <ul class="py-1">
                                <li>
                                <button @click="viewItem(task.slug)" class="block px-4 py-2 hover:bg-gray-100 w-full text-left">View</button>
                                </li>
                                <li>
                                <button @click="editTask(task)" class="block px-4 py-2 hover:bg-gray-100 w-full text-left">Edit</button>
                                </li>
                                <li>
                                <button @click="deleteItem(task.id)" class="block px-4 py-2 hover:bg-gray-100 w-full text-left text-red-500">Delete</button>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { useTasksStore } from '~/stores/task';
const taskStore = useTasksStore();
const dropdownOpen = ref<number | null>(null)

const isVisible = ref(false); 
const isEditMode = ref(false);
   
const currentTask = ref<any>({});

const editTask = (task: any) => {
  currentTask.value = task;

  isEditMode.value = true;
  isVisible.value = !isVisible.value;
}

const handleTaskSubmit = async (updatedTask :any) => {
    const response = await tasksStore.store(updatedTask);
    if(response == 'success'){
        isVisible.value = false;  
    } 
};

const toggleDropdown = (id: number) => {
    dropdownOpen.value = dropdownOpen.value === id ? null : id
}

const viewItem = (slug:string) => {
    const task = taskStore.viewTask(slug);
    currentTask.value = task;
}
const editItem = (item: any) => {
    alert(`Editing ${item.name}`)
}
const deleteItem = (item: any) => {
    if (confirm(`Delete ${item.name}?`)) {
        items.value = items.value.filter(i => i.id !== item.id)
    }
}
</script>