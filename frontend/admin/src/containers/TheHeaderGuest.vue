<template>
  <CHeader fixed with-subheader light>
    <CHeaderNav class="d-md-down-none mr-auto">
      <CHeaderNavItem class="px-3">
        <CHeaderNavLink to="/dashboard">
          LOGO
        </CHeaderNavLink>
      </CHeaderNavItem>
    </CHeaderNav>
    <CHeaderNav class="mr-4">
      <CHeaderNavItem class="d-md-down-none mx-2">
        <div class="language">
          <BoxLanguage />
        </div>
      </CHeaderNavItem>
    </CHeaderNav>
  </CHeader>
</template>

<script>
import BoxLanguage from "../components/BoxLanguage";

export default {
  name: "TheHeaderGuest",
  components: {
    BoxLanguage
  },
  data() {
    return {};
  },
  methods: {}
};
</script>
