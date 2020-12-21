<template>
  <CHeader fixed with-subheader light>
    <CToggler
      in-header
      class="ml-3 d-lg-none"
      @click="$store.commit('toggleSidebarMobile')"
    />
    <CToggler
      in-header
      class="ml-3 d-md-down-none"
      @click="$store.commit('toggleSidebarDesktop')"
    />
    <CHeaderBrand class="mx-auto d-lg-none" to="/">
      <CIcon name="logo" height="48" alt="Logo" />
    </CHeaderBrand>
    <CHeaderNav class="d-md-down-none mr-auto">
      <CHeaderNavItem class="px-3">
        <CHeaderNavLink to="/dashboard">
          Dashboard
        </CHeaderNavLink>
      </CHeaderNavItem>
      <CHeaderNavItem class="px-3">
        <CHeaderNavLink to="/users" exact>
          Users
        </CHeaderNavLink>
      </CHeaderNavItem>
      <CHeaderNavItem class="px-3">
        <CHeaderNavLink>
          Settings
        </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>
    <CHeaderNav class="mr-4">
      <CHeaderNavItem class="d-md-down-none mx-2">
        <div class="language">
          <BoxLanguage />
        </div>
      </CHeaderNavItem>
      <CHeaderNavItem class="d-md-down-none mx-2">
        <div class="notification-icon" @click.prevent="showBoxNotification">
          <CIcon name="cil-bell" />
        </div>
        <transition name="fade">
          <BoxNotification
            :notifications="notifications"
            @closeBoxNotification="showBoxNotification"
            v-if="boxNotificationStatus === true"
          />
        </transition>
      </CHeaderNavItem>
      <CHeaderNavItem class="d-md-down-none mx-2">
        <CHeaderNavLink>
          <CIcon name="cil-list" />
        </CHeaderNavLink>
      </CHeaderNavItem>
      <CHeaderNavItem class="d-md-down-none mx-2">
        <CHeaderNavLink>
          <CIcon name="cil-envelope-open" />
        </CHeaderNavLink>
      </CHeaderNavItem>
      <TheHeaderDropdownAccnt @handleLogout="handleLogout" />
    </CHeaderNav>
    <CSubheader class="px-3">
      <CBreadcrumbRouter class="border-0 mb-0" />
    </CSubheader>
  </CHeader>
</template>

<script>
import TheHeaderDropdownAccnt from "./TheHeaderDropdownAccnt";
import { mapActions } from "vuex";
import BoxNotification from "@/components/BoxNotification";
import BoxLanguage from "../components/BoxLanguage";

export default {
  name: "TheHeader",
  components: {
    BoxLanguage,
    BoxNotification,
    TheHeaderDropdownAccnt
  },
  data() {
    return {
      boxNotificationStatus: false,
      notifications: [
        {
          image:
            "https://zicxaphotos.com/wp-content/uploads/2020/07/girl-xinh-cap-3-1.jpg",
          title: "Tao thich thong bao",
          date: "01-12-2020"
        },
        {
          image:
            "https://zicxaphotos.com/wp-content/uploads/2020/07/girl-xinh-cap-3-1.jpg",
          title: "Tao thich thong bao",
          date: "01-12-2020"
        },
        {
          image:
            "https://zicxaphotos.com/wp-content/uploads/2020/07/girl-xinh-cap-3-1.jpg",
          title: "Tao thich thong bao",
          date: "01-12-2020"
        }
      ]
    };
  },
  methods: {
    ...mapActions("auth", ["logout"]),
    showBoxNotification() {
      this.boxNotificationStatus = !this.boxNotificationStatus;
    },
    async handleLogout() {
      await this.logout();
      this.$router.push({ name: "SignIn" });
    }
  }
};
</script>

<style lang="scss">
.notification-icon {
  position: relative;
  cursor: pointer;
}
.notification {
  position: absolute;
  top: -20px;
  right: 58px;
}
</style>
