<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="8">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <ValidationObserver v-slot="{ handleSubmit }" ref="form">
                  <CForm @submit.prevent="handleSubmit(login)">
                    <h1>Login</h1>
                    <p class="text-muted">Sign In to your account</p>
                    <ValidationProvider
                      v-slot="{ errors }"
                      :name="$t('login.user_name')"
                      rules="required|email|min:10|max:100"
                    >
                      <CInput
                        placeholder="Username"
                        autocomplete="off"
                        v-model.trim="formSignIn.email"
                        :class="[errors[0] ? 'is-invalid' : '']"
                      >
                        <template #prepend-content
                          ><CIcon name="cil-user"
                        /></template>
                      </CInput>
                      <div v-if="errors[0]" class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </ValidationProvider>
                    <ValidationProvider
                      v-slot="{ errors }"
                      vid="password"
                      :name="$t('login.password')"
                      rules="required|min:6|max:50"
                    >
                      <CInput
                        placeholder="Password"
                        type="password"
                        v-model.trim="formSignIn.password"
                        autocomplete="off"
                        :class="[errors[0] ? 'is-invalid' : '']"
                      >
                        <template #prepend-content
                          ><CIcon name="cil-lock-locked"
                        /></template>
                      </CInput>
                      <div v-if="errors[0]" class="invalid-feedback">
                        {{ errors[0] }}
                      </div>
                    </ValidationProvider>
                    <CRow>
                      <CCol col="6" class="text-left">
                        <CButton color="primary" type="submit" class="px-4"
                          >Login</CButton
                        >
                      </CCol>
                      <CCol col="6" class="text-right">
                        <router-link
                          to="reset-password"
                          color="link"
                          class="px-0"
                        >
                          Forgot password?
                        </router-link>
                        <CButton color="link" class="d-lg-none"
                          >Register now!</CButton
                        >
                        <CButton class="btn btn-primary" @click="redirectGoogle"
                          >Login with google</CButton
                        >
                      </CCol>
                    </CRow>
                  </CForm>
                </ValidationObserver>
              </CCardBody>
            </CCard>
            <CCard
              color="primary"
              text-color="white"
              class="text-center py-5 d-md-down-none"
              body-wrapper
            >
              <CCardBody>
                <h2>Sign up</h2>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                  do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
                <CButton color="light" variant="outline" size="lg">
                  Register Now!
                </CButton>
              </CCardBody>
            </CCard>
          </CCardGroup>
        </CCol>
      </CRow>
    </CContainer>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import { ValidationObserver, ValidationProvider } from "vee-validate";
export default {
  name: "SignIn",
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      formSignIn: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    ...mapActions("auth", ["signIn"]),
    async login() {
      await this.signIn(this.formSignIn)
        .then(() => {
          this.$router.push({ name: "Home" });
        })
        .catch(() => {});
    },
    async redirectGoogle() {
      await this.$store.dispatch("auth/redirectGoogle").then(response => {
        window.open(response.data.url);
      });
    }
  }
};
</script>
