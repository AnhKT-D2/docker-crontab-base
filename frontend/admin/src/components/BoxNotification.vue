<template>
  <div class="notification">
    <div
      class="dropdown-menu notification-ui_dd show"
      aria-labelledby="navbarDropdown"
    >
      <div
        class="notification-ui_dd-header d-flex justify-content-between align-items-center"
      >
        <h3 class="text-center">Notification</h3>
        <span class="close-notification" @click.prevent="closeBoxNotification"
          >X</span
        >
      </div>
      <div class="notification-ui_dd-content">
        <div v-for="(notification, index) in notifications" :key="index">
          <div class="notification-list notification-list--unread">
            <div class="notification-list_img">
              <img :src="notification.image" alt="user" />
            </div>
            <div class="notification-list_detail">
              <p>{{ notification.title }}</p>
              <p>
                <small>{{ notification.date }}</small>
              </p>
            </div>
            <div class="notification-list_feature-img">
              <img src="https://i.imgur.com/AbZqFnR.jpg" alt="Feature image" />
            </div>
          </div>
        </div>
        <!--        <div class="notification-list">-->
        <!--          <div class="notification-list_img">-->
        <!--            <img src="https://i.imgur.com/ltXdE4K.jpg" alt="user" />-->
        <!--          </div>-->
        <!--          <div class="notification-list_detail">-->
        <!--            <p><b>Brian Cumin</b> reacted to your post</p>-->
        <!--            <p><small>1 day ago</small></p>-->
        <!--          </div>-->
        <!--          <div class="notification-list_feature-img">-->
        <!--            <img src="https://i.imgur.com/bpBpAlH.jpg" alt="Feature image" />-->
        <!--          </div>-->
        <!--        </div>-->
      </div>
      <div class="notification-ui_dd-footer">
        <a href="#!" class="btn btn-success btn-block">View All</a>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "BoxNotification",
  props: {
    notifications: {
      type: [Array, Object]
    }
  },
  methods: {
    closeBoxNotification() {
      this.$emit("closeBoxNotification");
    }
  }
};
</script>
<style lang="scss" scoped>
.notification {
  .notification-ui_dd {
    padding: 0;
    border-radius: 10px;
    -webkit-box-shadow: 0 5px 20px -3px rgba(0, 0, 0, 0.16);
    box-shadow: 0 5px 20px -3px rgba(0, 0, 0, 0.16);
    border: 0;
    max-width: 400px;
    &:after {
      content: "";
      position: absolute;
      top: -30px;
      left: calc(50% - 7px);
      border-top: 15px solid transparent;
      border-right: 15px solid transparent;
      border-bottom: 15px solid #fff;
      border-left: 15px solid transparent;
    }
    .notification-ui_dd-header {
      border-bottom: 1px solid #ddd;
      padding: 15px;
      h3 {
        margin-bottom: 0;
      }
      .close-notification {
        cursor: pointer;
      }
    }
    .notification-ui_dd-content {
      max-height: 500px;
      overflow: auto;
    }
  }
  .notification-list {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 20px 0;
    margin: 0 25px;
    border-bottom: 1px solid #ddd;
    .notification-list_img {
      img {
        height: 48px;
        width: 48px;
        border-radius: 50px;
        margin-right: 20px;
      }
    }
    .notification-list_detail {
      p {
        margin-bottom: 5px;
        line-height: 1.2;
      }
    }
    .notification-list_feature-img {
      img {
        height: 48px;
        width: 48px;
        border-radius: 5px;
        margin-left: 20px;
      }
    }
  }
  .notification-list--unread {
    position: relative;
    &:before {
      content: "";
      position: absolute;
      top: 0;
      left: -25px;
      height: calc(100% + 1px);
      border-left: 2px solid #29b6f6;
    }
  }
  @media (min-width: 900px) {
    .notification-ui_dd {
      min-width: 400px;
      position: absolute;
      left: -192px;
      top: 70px;
    }
  }
}
</style>
