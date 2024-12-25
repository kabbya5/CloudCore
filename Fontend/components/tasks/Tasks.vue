<template>
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
                    <td class="p-2">
                        <button @click="viewTask(task)" class="text-blue-500 hover:underline">
                            View
                        </button>
        
                        <button @click="editTask(task)" class="text-green-500 hover:underline">
                            Edit
                        </button>
        
                        <button @click="deleteTask(task.id)" class="text-red-500 hover:underline">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { useTasksStore } from '~/stores/task';
const taskStore = useTasksStore();
console.log('tssk',taskStore.tasks);

</script>