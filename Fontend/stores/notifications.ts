import { defineStore } from 'pinia';

export const useNotificationsStore = defineStore('notifications', {
  state: () => ({
    notifications: []
  }),

  actions: {
    addNotification(message, type = 'success') {
      
      const id = Date.now();
      this.notifications.push({ id, message, type });

      setTimeout(() => {
        this.removeNotification(id);
      }, 3000);
    },

    removeNotification(id) {
      this.notifications = this.notifications.filter(notification => notification.id !== id);
    }
  }
});
