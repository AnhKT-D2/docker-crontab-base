<template>
  <div id="myModal" :class="['modal', { active: isActive }]">
    <CSpinner color="primary" style="width:5rem;height:5rem;" />
  </div>
</template>

<script>
export default {
  name: "Spinner",
  props: ["isActive"]
};
</script>

<style lang="scss" scoped>
.modal {
  display: none;
  position: fixed;
  align-items: center;
  justify-content: center;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.active {
  display: flex;
}
</style>
