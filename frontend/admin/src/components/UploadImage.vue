<template>
  <CRow>
    <CCol>
      <div id="app">
        <input
          type="file"
          ref="file"
          multiple="multiple"
          accept="image/*"
          @change="previewImages"
          name="images"
        />
        <div class="wrapper-preview">
          <div v-for="(image, index) in showImages" class="wrapper-image">
            <!--            <span @click.prevent="removeTagUser(index)" class="removeTagUser">-->
            <!--              x-->
            <!--            </span>-->
            <img
              :src="image"
              :class="['preview', { active: isAvatar === index }]"
              @click.prevent="pickAvatar(index)"
            />
          </div>
        </div>
      </div>
    </CCol>
  </CRow>
</template>

<script>
export default {
  name: "UploadImage",
  data() {
    return {
      showImages: [],
      isAvatar: 0,
      images: null,
      formData: new FormData()
    };
  },
  methods: {
    pickAvatar(index) {
      this.isAvatar = index;
      this.formData.append("isAvatar", index);
      this.$emit("uploadImage", this.formData);
    },
    previewImages(e) {
      this.showImages = [];
      this.isAvatar = 0;
      let fileList = Array.prototype.slice.call(e.target.files);
      this.images = fileList;
      if (fileList.length > 5) {
        this.showImages = [];
        alert("No more than 5 images");
        return;
      }
      fileList.forEach(f => {
        if (!f.type.match("image.*")) {
          return;
        }

        let reader = new FileReader();
        let that = this;
        reader.onload = function(e) {
          that.showImages.push(e.target.result);
        };
        reader.readAsDataURL(f);
      });
      for (let i = 0; i < fileList.length; i++) {
        let file = fileList[i];
        this.formData.append("files[" + i + "]", file);
      }
      this.formData.append("isAvatar", this.isAvatar);
      this.$emit("uploadImage", this.formData);
    }
    // removeTagUser(index) {
    //   if (index < this.isAvatar) {
    //     this.isAvatar--;
    //   }
    //   this.showImages.splice(index, 1);
    //   this.images.splice(index, 1);
    // }
  }
};
</script>

<style lang="scss" scoped>
.active {
  box-shadow: 0 0 30px #29b6f6;
}
.wrapper-preview {
  padding: 5px;
  width: 100%;
  display: flex;
  div {
    box-shadow: 0 0 3px #4a5568;
    width: 20%;
    padding: 5px;
    margin: 3px;
    .preview {
      width: 100%;
    }
  }

  .wrapper-image {
    position: relative;
  }

  .removeTagUser {
    position: absolute;
    font-size: 30px;
    color: red;
    right: 0;
    top: -15px;
    &:hover {
      cursor: pointer;
    }
  }
}
</style>
