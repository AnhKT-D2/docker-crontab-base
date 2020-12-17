<template>
  <div id="app">
    <component :is="layout" v-if="layout" />
  </div>
</template>

<script>
export default {
  name: "App",
  computed: {
    layout() {
      return this.$route.meta.layout || "GuestLayout";
    }
  }
};
</script>

<style lang="scss">
// Import Main styles for this application
@import "assets/scss/style";
</style>
