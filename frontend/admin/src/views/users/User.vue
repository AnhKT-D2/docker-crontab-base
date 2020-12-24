<template>
  <CRow>
    <CCol col="12" lg="12">
      <CCard>
        <CCardHeader>
          <CCarousel
            arrows
            indicators
            animate
            height="450px"
            class="custom-img"
          >
            <CCarouselItem
              v-for="(photo, index) in coverPhoto"
              :image="driveUrlImage + photo"
              :class="{ active: index === 0 }"
            />
          </CCarousel>
          <div class="custom-avatar">
            <img :src="driveUrlImage + avatar" class="c-avatar" />
          </div>
        </CCardHeader>
        <CCardBody> </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import { mapGetters } from "vuex";
import { DRIVE_URL_IMAGE } from "@/commons/constant";

export default {
  name: "User",
  data() {
    return {
      coverPhoto: [],
      avatar: null,
      driveUrlImage: DRIVE_URL_IMAGE
    };
  },
  created() {
    this.showUser();
  },
  methods: {
    async showUser() {
      await this.$store
        .dispatch("user/showUser", this.$route.params.id)
        .then(res => {
          res.data.avatars.forEach(image => {
            if (image.is_avatar === 1) {
              this.avatar = image.path;
            } else {
              this.coverPhoto.push(image.path);
            }
          });
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

<style lang="scss">
.custom-img {
  img {
    max-height: 450px;
  }
  position: relative;
}

.custom-avatar {
  img {
    width: 200px;
    height: 200px;
    position: absolute;
    bottom: 0;
    border: #29b6f6 2px solid;
    padding: 1px;
    margin-left: 100% - 55%;
  }
}

.active {
  display: block;
}
</style>
