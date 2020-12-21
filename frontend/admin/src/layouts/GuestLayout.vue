<template>
  <div id="guest">
    <TheHeaderGuest />
    <router-view />
  </div>
</template>

<script>
import TheHeaderGuest from "../containers/TheHeaderGuest";
export default {
  name: "GuestLayout",
  components: { TheHeaderGuest }
};
</script>
