<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CCol col="12">
                  <div class="form-forgot">
                    <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                      <CForm @submit.prevent="handleSubmit(resetPassword)">
                        <div>
                          <ValidationProvider
                            v-slot="{ errors }"
                            rules="required|min:8|max:20|confirmed:confirm"
                            :name="$t('users.label.password')"
                          >
                            <CInput
                              :label="$t('users.label.password')"
                              type="password"
                              v-model="password"
                              :class="[errors[0] ? 'is-invalid' : '']"
                            />
                            <div v-if="errors[0]" class="invalid-feedback">
                              {{ errors[0] }}
                            </div>
                          </ValidationProvider>
                        </div>
                        <div>
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
                          <CButton
                            class="btn btn-primary"
                            @click="resetPassword"
                          >
                            Reset password
                          </CButton>
                        </div>
                      </CForm>
                    </ValidationObserver>
                  </div>
                </CCol>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";

export default {
  name: "ResetForm",
  components: {
    ValidationProvider,
    ValidationObserver
  },
  data() {
    return {
      password: "",
      confirmPassword: ""
    };
  },
  methods: {
    async resetPassword() {
      await this.$store
        .dispatch("user/resetPassword", {
          password: this.password,
          token: this.$route.params.token
        })
        .then(() => {
          this.$toast.success(this.$i18n.t("success.password_change"), {
            position: "top-right"
          });
          this.$router.push({ name: "SignIn" });
        })
        .catch(() => {
          this.$toast.error(this.$i18n.t("error.4015"), {
            position: "top-right"
          });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.form-forgot {
  button {
    display: block;
    margin: auto;
  }
}
</style>
