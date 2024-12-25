import { defineStore } from 'pinia';
import { useNotificationsStore } from '../stores/notifications';

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tasks: [] as any[],
    loading: false,
    page: 1,
    limit: 20,
    hasMore: true,
  }),
  
  actions: {
    async fetchTasks(status = 'progress', priority = 'high',resetPagination = false) {
        if(this.page === 1){
            this.tasks = [];
        }
        if (this.loading || !this.hasMore) return;
        
        this.loading = true;

        if (resetPagination) {
            this.page = 1;
            this.tasks = [];  
            this.hasMore = true;
        }
        try {
            const queryParams = new URLSearchParams({
                page: String(this.page),
                limit: String(this.limit),
                status,
                priority,
              });

            const response = await useCustomFetch(`/tasks?${queryParams.toString()}`);
            const rawValue = response._rawValue;
           
            if (rawValue && rawValue.tasks && Array.isArray(rawValue.tasks)) {
                const tasks = rawValue.tasks;
                if (tasks.length < this.limit) {
                    this.hasMore = false;
                }
                this.tasks.push(...tasks);
                this.page++;
               
            } else {
                console.error('Response data is missing:', response);
            }
        } catch (error) {
            console.error('Error fetching tasks:', error);
        } finally {
          this.loading = false;
        }
    },

   async store(task){
      try{
        const notificationsStore = useNotificationsStore(); 
        const response = await useCustomFetch('/tasks',{
          method: 'POST',
          body: task as taskForm,
        });
        const rawValue = response._rawValue;
        if(rawValue){
          notificationsStore.addNotification("Then task hass been created successfully","success");
          return 'success';
        }
      }catch(error){
        console.log(error);
        return false;
      }
    },

    async liketask(taskId:number){
      
      const baseUrl = getBaseUrl();
      const task = this.tasks.find(p => p.id === taskId);
      if(task){
        try{
          await useCustomFetch(`${baseUrl}/tasks/${taskId}/like`,{method:'task'});
          if(task.isLiked){
            task.isLiked = false;
            task.likes_count--
          }else{
            task.isLiked = true;
            task.likes_count++;
          }
          
        }catch(error){
          notificationStore.addNotification('Failed to like/unlike the task','error');
        }
      }
    }
  },

});
