<template>
  <div class="c-app flex-row align-items-center">
    <CContainer>
      <CRow class="justify-content-center">
        <CCol md="6">
          <CCardGroup>
            <CCard class="p-4">
              <CCardBody>
                <CCol col="12">
                  <div class="box-forgot">
                    <b>
                      Enter your user account's verified email address and we
                      will send you a password reset link
                    </b>
                    <CInput
                      placeholder="Type your email"
                      v-model="email"
                    ></CInput>
                    <CButton class="btn btn-primary" @click="sendMail">
                      Send email
                    </CButton>
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
export default {
  name: "ForgotPassword",
  data() {
    return {
      email: ""
    };
  },
  methods: {
    async sendMail() {
      await this.$store
        .dispatch("user/requestSendMail", { email: this.email })
        .then(() => {
          this.$toast.success(this.$i18n.t("success.send_mail"), {
            position: "top-right"
          });
        })
        .catch(() => {
          this.$toast.error(this.$i18n.t("error.mail_exists"), {
            position: "top-right"
          });
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.box-forgot {
  button {
    display: block;
    margin: auto;
  }
}
</style>
