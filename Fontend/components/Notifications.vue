<template>
    <div class="notification-container">

        <div  v-for="notification in notifications" :key="notification.id" 
            class="notification" :class="notification.type" 
                @click="notificationStore.removeNotification(notification.id)">
            <span>{{ notification.message }}</span>
        </div>
    </div>
  </template>
  <script setup lang="ts">
  import { useNotificationsStore } from '~/stores/notifications';

  const notificationStore = useNotificationsStore();
  const notifications = computed(() => notificationStore.notifications);

  console.log('notification',notifications);

  </script>

<style scoped>
.notification-container {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 1000;
}
.notification {
  position: fixed;
  bottom: 30px;
  right: 30px;
  padding: 15px 25px;
  border-radius: 8px;
  color: white;
  font-weight: bold;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  z-index: 1000;
}

.success {
  background-color: #28a745;
}

.error {
  background-color: #dc3545;
}

.warning {
  background-color: #ffc107;
}

.info {
  background-color: #17a2b8;
}
</style>