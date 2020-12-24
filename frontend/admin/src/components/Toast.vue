<template>
  <CToaster :autohide="2000">
    <CToast :show="isActive" :class="status">
      {{ content }}
    </CToast>
  </CToaster>
</template>

<script>
export default {
  name: "CustomToast",
  props: {
    isActive: Boolean,
    content: String,
    status
  },
  data() {
    return {
      fixedToasts: 0
    };
  }
};
</script>

<style scoped></style>
