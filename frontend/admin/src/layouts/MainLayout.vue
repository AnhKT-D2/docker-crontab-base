<template>
  <div id="main">
    <router-view />
  </div>
</template>

<script>
import firebase from "@/plugins/firebase";

export default {
  name: "MainLayout",
  data() {
    return {};
  },
  mounted() {
    this.getTokenFirebase();
  },
  methods: {
    getTokenFirebase() {
      const self = this;
      const messaging = firebase.messaging();
      messaging
        .requestPermission()
        .then(function() {
          return messaging.getToken();
        })
        .then(function(token) {
          console.log(token);
          self.$store.dispatch("notification/saveDeviceToken", {
            user_id: 1,
            device_token: token
          });
        })
        .catch(function(err) {
          console.log("Unable to get permission to notify.", err);
        });

      let enableForegroundNotification = true;
      messaging.onMessage(function(payload) {
        alert(payload);
        console.log("Message received. ", payload);
        if (enableForegroundNotification) {
          const { title, ...options } = JSON.parse(payload.data.notification);
          navigator.serviceWorker.getRegistrations().then(registration => {
            registration[0].showNotification(title, options);
          });
        }
      });
    }
  }
};
</script>
