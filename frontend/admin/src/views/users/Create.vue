<template>
  <div>
    <Spinner :is-active="isActive" />
    <CRow>
      <CCol col="12" xl="12">
        <CCard>
          <CCardHeader>
            <div>
              <h3>{{ $t("users.label.create_user") }}</h3>
            </div>
          </CCardHeader>
          <CCardBody>
            <div class="form-user">
              <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                <CForm @submit.prevent="handleSubmit(createUser)">
                  <CRow>
                    <CCol sm="6">
                      <ValidationProvider
                        v-slot="{ errors }"
                        rules="required|max:50"
                        :name="$t('users.label.name')"
                      >
                        <CInput
                          :label="$t('users.label.name')"
                          v-model="user.name"
                          :class="[errors[0] ? 'is-invalid' : '']"
                        />
                        <div v-if="errors[0]" class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </ValidationProvider>
                    </CCol>
                    <CCol sm="6">
                      <ValidationProvider
                        v-slot="{ errors }"
                        rules="required|email|min:10|max:50"
                        name="email"
                      >
                        <CInput
                          label="Email"
                          type="email"
                          v-model="user.email"
                          :class="[errors[0] ? 'is-invalid' : '']"
                        />
                        <div v-if="errors[0]" class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </ValidationProvider>
                    </CCol>
                  </CRow>
                  <CRow>
                    <CCol sm="6">
                      <ValidationProvider
                        v-slot="{ errors }"
                        rules="required|integer|max:11"
                        :name="$t('users.label.phone')"
                      >
                        <CInput
                          :label="$t('users.label.phone')"
                          v-model="user.phone"
                          :class="[errors[0] ? 'is-invalid' : '']"
                        />
                        <div v-if="errors[0]" class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </ValidationProvider>
                    </CCol>
                    <CCol sm="6">
                      <CSelect
                        :label="$t('users.label.role')"
                        :options="role"
                        :placeholder="$t('users.label.role_placeholder')"
                        @update:value="pickRole"
                      />
                    </CCol>
                  </CRow>
                  <CRow>
                    <CCol sm="6">
                      <ValidationProvider
                        v-slot="{ errors }"
                        rules="required|min:8|max:20|confirmed:confirm"
                        :name="$t('users.label.password')"
                      >
                        <CInput
                          :label="$t('users.label.password')"
                          type="password"
                          v-model="user.password"
                          :class="[errors[0] ? 'is-invalid' : '']"
                        />
                        <div v-if="errors[0]" class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </ValidationProvider>
                    </CCol>
                    <CCol sm="6">
                      <ValidationProvider
                        v-slot="{ errors }"
                        rules="required"
                        vid="confirm"
                        :name="$t('users.label.confirm_password')"
                      >
                        <CInput
                          :label="$t('users.label.confirm_password')"
                          type="password"
                          v-model="confirmPassword"
                          :class="[errors[0] ? 'is-invalid' : '']"
                        />
                        <div v-if="errors[0]" class="invalid-feedback">
                          {{ errors[0] }}
                        </div>
                      </ValidationProvider>
                    </CCol>
                  </CRow>
                  <div>
                    <label>{{ $t("users.label.pick_avatar") }}</label>
                    <UploadImage @uploadImage="getImages($event)" />
                  </div>
                  <div class="wrapper-btn-create">
                    <CButton color="primary" type="submit">
                      {{ $t("users.button.create") }}
                    </CButton>
                  </div>
                </CForm>
              </ValidationObserver>
            </div>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>

<script>
import UploadImage from "@/components/UploadImage";
import { IS_MANAGER, IS_MEMBER, IS_SUPPER_ADMIN } from "@/commons/constant";
import Spinner from "@/components/Spinner";
import { ValidationObserver, ValidationProvider } from "vee-validate";
export default {
  name: "CreateUpdate",
  components: {
    Spinner,
    UploadImage,
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      isActive: false,
      user: {
        name: "",
        email: "",
        phone: "",
        level: "",
        password: ""
      },
      confirmPassword: "",
      role: [
        { value: IS_SUPPER_ADMIN, label: this.$i18n.t("common.supper_admin") },
        { value: IS_MANAGER, label: this.$i18n.t("common.manager") },
        { value: IS_MEMBER, label: this.$i18n.t("common.member") }
      ],
      urlImages: [],
      formData: null,
      isUpdate: false
    };
  },
  methods: {
    getImages(event) {
      this.formData = event;
    },
    pickRole(role) {
      this.user.level = role;
    },
    async createUser() {
      if (this.formData === null) {
        return this.$toast.error(this.$i18n.t("users.error.has_avatar"), {
          position: "top-right"
        });
      }

      if (this.user.level === "") {
        return this.$toast.error(this.$i18n.t("users.error.has_role"), {
          position: "top-right"
        });
      }

      this.isActive = true;
      for (let key in this.user) {
        this.formData.append(key, this.user[key]);
      }
      await this.$store
        .dispatch("user/createUser", this.formData)
        .then(() => {
          this.isActive = false;
          this.$toast.success(this.$i18n.t("success.users.create_ok"), {
            position: "top-right"
          });
          this.$router.push({ path: "/users" });
        })
        .catch(() => {
          this.isActive = false;
          this.$toast.error(this.$i18n.t("error.5000"), {
            position: "top-right"
          });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.wrapper-btn-create {
  button {
    display: block;
    margin: auto;
  }
}
</style>
