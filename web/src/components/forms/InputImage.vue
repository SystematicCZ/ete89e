<template>
  <div>
    <input
      ref="imageInput"
      type="file"
      accept="image/*"
      hidden
      @change="onImagePicked"
    >
    <div
      v-show="isCollapsed"
      class="border"
    >
      <div
        class="form-control-image mb-0 color--primary"
      >
        <img
          :src="preview"
          :width="width"
          :height="height"
          alt="Profile picture preview"
        >
      </div>
      <b-button
        variant="link"
        class="add-profile-picture btn-light btn"
        @click="choose"
      >
        <b-icon icon="pencil"/>
      </b-button>
      <b-button
        v-if="image && backendDelete"
        class="delete-profile-picture btn-light btn"
        @click="emitDeleteOnBackend"
      ></b-button>
    </div>
    <div v-show="!isCollapsed" class="croppie-wrapper">
      <div
        class="edit-picture-top shadow d-flex border"
      >
        <div class="col text-secondary py-2 px-2 text-left">
          Oříznout
        </div>
        <b-button
          class="save-profile-picture text-success btn-light btn border-left"
          @click="save"
        >
          Uložit
        </b-button>
      </div>
      <div
        ref="croppieContainer"
        class="form-control-image mb-0 color--primary"
      >
      </div>
      <div
        class="edit-picture-bottom border d-flex"
      >
        <b-button
          variant="link"
          class="btn btn-light"
          @click="zoomOut"
        >
          <b-icon icon="zoom-out"/>
        </b-button>

        <b-button
          variant="link"
          class="btn btn-light"
          @click="zoomIn"
        >
          <b-icon icon="zoom-in"/>
        </b-button>
        <b-button
          variant="link"
          class="text-secondary btn ml-auto border-0 h-auto position-static bg-white"
          @click="cancel"
        >
          <b-icon icon="x"/>
        </b-button>
      </div>
    </div>
  </div>
</template>
<script>
import 'croppie/croppie.css';
import Croppie from 'croppie';

export default {
  props: {
    zoomStep: { type: Number, default: 0.03 },
    image: { type: String, default: null },
    placeholder: { type: String, default: 'build/images/svg/add_picture_placeholder.svg' },
    circle: { type: Boolean, default: false },
    backendDelete: { type: Boolean, default: false },
    maxFileSize: { type: Number, default: 10000000 },
    value: { type: String, default: null },
    width: { type: Number, default: 170 },
    height: { type: Number, default: 170 },
  },
  data() {
    return {
      isCollapsed: true,
      croppie: null,
      croppieOptions: {
        viewport: {
          width: this.width,
          height: this.height,
          type: (this.circle) ? 'circle' : 'square',
        },
        boundary: {
          width: this.width,
          height: this.height,
        },
        showZoomer: false,
      },
      data: {
        original: null,
        cropped: this.value,
      },
    };
  },
  computed: {
    preview() {
      if (this.data.cropped) {
        return this.data.cropped;
      }
      return (this.image) ? this.image : this.placeholder;
    },
  },
  methods: {
    zoomIn() {
      this.croppie.setZoom(this.croppie.get().zoom += this.zoomStep);
    },
    zoomOut() {
      this.croppie.setZoom(this.croppie.get().zoom -= this.zoomStep);
    },
    choose() {
      this.$refs.imageInput.click();
    },
    cancel() {
      this.emitFinished();
      this.destroyCroppie();
    },
    save() {
      this.croppie.result('base64').then((data) => {
        this.data.cropped = data;
        this.emitFinished();
        this.emitInput();
        this.destroyCroppie();
      });
    },
    onImagePicked(event) {
      if (event.target.files[0].size > this.maxFileSize) {
        this.emitFileSizeExceeded();
        return;
      }

      this.emitEdit();
      this.readAsDataURL(event.target.files[0]).then((data) => {
        this.data.original = data;
        this.mountCroppie(data);
      });
    },
    mountCroppie(image) {
      this.isCollapsed = false;
      this.$nextTick(() => {
        this.croppie = new Croppie(this.$refs.croppieContainer, this.croppieOptions);
        this.croppie.bind({
          url: image,
        });
      });
    },
    destroyCroppie() {
      this.croppie.destroy();
      this.isCollapsed = true;
    },
    readAsDataURL(file) {
      return new Promise((resolve, reject) => {
        const fileReader = new FileReader();
        fileReader.onerror = reject;
        fileReader.onload = () => {
          resolve(fileReader.result);
        };
        fileReader.readAsDataURL(file);
      });
    },
    emitInput() {
      this.$emit('input', this.data.cropped);
      this.data.original = null;
      this.data.cropped = null;
    },
    emitEdit() {
      this.$emit('edit');
    },
    emitFinished() {
      this.$emit('finished');
    },
    emitDeleteOnBackend() {
      this.$emit('backend-delete-requested');
    },
    emitFileSizeExceeded() {
      this.$emit('file-size-exceeded');
    },
  },
};
</script>
<style scoped lang="scss">
.cr-slider-wrap {
  display: none;
}

.add-profile-picture {
  position: absolute;
  right: 0;
}
</style>
