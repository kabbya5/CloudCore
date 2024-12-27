import { defineStore } from 'pinia';
import { useNotificationsStore } from '../stores/notifications';

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tasks: [] as any[],
    loading: false,
    page: 1,
    limit: 20,
    hasMore: true,
    priority:'',
    status:'',
    order_by:'',
  }),
  
  actions: {
    async fetchTasks(status = '', priority = '', search_query = '', due_date ='', order_by = '') {
        if(this.page === 1){
            this.tasks = [];
        }
        if (this.loading || !this.hasMore) return;
        
        this.loading = true;

        if (this.priority != priority || this.status != status || this.order_by != order_by ) {
            this.page = 1;
            this.tasks = [];  
            this.hasMore = true;
            this.order_by = order_by;
            this.priority = priority;
            this.status = status;
        }
        try {
            const queryParams = new URLSearchParams({
                page: String(this.page),
                limit: String(this.limit),
                status,
                priority,
                search_query,
                order_by,
                due_date,
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
               
            }else{
              console.log(response);
            }
        } catch (error) {
            console.error('Error fetching tasks:', error);
        } finally {
          this.loading = false;
        }
    },

    async store(task:any){
      try{
          const notificationsStore = useNotificationsStore(); 
          const response = await useCustomFetch('/tasks',{
            method: 'POST',
            body: task,
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

    async viewTask(slug:string){
      try{

        const response = await useCustomFetch(`/tasks/${slug}`,);
        const task = response.value.task;
        if(task){
            return task; 
        }else{
          return null;
        }
      }catch(error){
        console.log(error);
        return false;
      }
    },

  },
});
