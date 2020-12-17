<template>
  <div class="c-app">
    <TheSidebar />
    <CWrapper>
      <TheHeader />
      <div class="c-body">
        <main class="c-main">
          <CContainer fluid>
            <transition name="fade" mode="out-in">
              <router-view :key="$route.path"></router-view>
            </transition>
          </CContainer>
        </main>
      </div>
      <TheFooter />
    </CWrapper>
  </div>
</template>

<script>
import TheSidebar from "./TheSidebar";
import TheHeader from "./TheHeader";
import TheFooter from "./TheFooter";
import firebase from "@/plugins/firebase";

export default {
  name: "TheContainer",
  components: {
    TheSidebar,
    TheHeader,
    TheFooter
  },
  data() {
    return {};
  },
  created() {
    this.getTokenFirebase();
  },
  methods: {
    getTokenFirebase() {
      const messaging = firebase.messaging();
      messaging
        .requestPermission()
        .then(function() {
          return messaging.getToken();
        })
        .then(function(token) {
          console.log(token);
        })
        .catch(function(err) {
          console.log("Unable to get permission to notify.", err);
        });

      let enableForegroundNotification = true;
      messaging.onMessage(function(payload) {
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

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
