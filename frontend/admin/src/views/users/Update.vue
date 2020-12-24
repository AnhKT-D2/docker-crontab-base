<template>
  <div>
    <Spinner :is-active="isActive" />
    <CRow>
      <CCol col="12" xl="12">
        <CCard>
          <CCardHeader>
            <div>
              <h3>{{ $t("users.label.update_user") }}</h3>
            </div>
          </CCardHeader>
          <CCardBody>
            <div class="form-user">
              <CRow>
                <CCol sm="6">
                  <CInput
                    :label="$t('users.label.name')"
                    v-model="user.user.name"
                  />
                </CCol>
                <CCol sm="6">
                  <CInput
                    label="Email"
                    type="email"
                    v-model="user.user.email"
                  />
                </CCol>
              </CRow>
              <CRow>
                <CCol sm="6">
                  <CInput
                    :label="$t('users.label.phone')"
                    v-model="user.user.phone"
                  />
                </CCol>
                <CCol sm="6">
                  <CSelect
                    :label="$t('users.label.role')"
                    :options="role"
                    :placeholder="$t('users.label.role_placeholder')"
                    :value="user.user.level"
                    @update:value="pickRole"
                  />
                </CCol>
              </CRow>
            </div>
            <div class="wrapper-btn-create">
              <CButton color="primary" @click="updateUser">
                {{ $t("users.button.update") }}
              </CButton>
            </div>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>

<script>
import { IS_MANAGER, IS_MEMBER, IS_SUPPER_ADMIN } from "@/commons/constant";
import { mapGetters } from "vuex";
import Spinner from "@/components/Spinner";

export default {
  name: "Update",
  components: { Spinner },
  data() {
    return {
      isActive: false,
      role: [
        { value: IS_SUPPER_ADMIN, label: this.$i18n.t("common.supper_admin") },
        { value: IS_MANAGER, label: this.$i18n.t("common.manager") },
        { value: IS_MEMBER, label: this.$i18n.t("common.member") }
      ]
    };
  },
  created() {
    this.getUser();
  },
  methods: {
    async getUser() {
      await this.$store.dispatch("user/showUser", this.$route.params.id);
    },
    pickRole(role) {
      this.user.user.level = role;
    },
    async updateUser() {
      this.isActive = true;
      await this.$store.dispatch("user/updateUser", this.user.user).then(() => {
        this.isActive = false;
        this.$toast.success("ok", { position: "top-right" });
        this.$router.push("/users");
      });
    }
  },
  computed: {
    ...mapGetters({
      user: "user/user"
    })
  }
};
</script>

<style scoped></style>
