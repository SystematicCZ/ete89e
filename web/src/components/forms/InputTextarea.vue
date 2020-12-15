<template>
  <div class="form-group input-group">
    <template v-if="wysiwyg">
      <div
        :class="{
          'is-valid': validations && validations.$success,
          'is-invalid': validations && validations.$error,
        }"
        class="w-100">
        <froala
          :config="froalaConfiguration"
          :value="value"
          tag="textarea"
          @input="(event) => $emit('input', event)"
        />

        <input
          :value="value"
          type="hidden"
        >
      </div>
    </template>

    <textarea
      v-else
      :class="{
        'is-valid': validations && validations.$success,
        'is-invalid': validations && validations.$error,
      }"
      :rows="rows"
      :value="value"
      :placeholder="placeholder"
      class="form-control"
      @input="$emit('input', $event.target.value)"
    />
    <div class="col-12 px-0">
      <slot name="bottom-template"></slot>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    rows: { type: Number, default: 5 },
    validations: { type: Object, default: null },
    value: { type: String, required: true },
    placeholder: { type: String, default: '' },
    wysiwyg: { type: Boolean, default: false },
    disableMultimedia: { type: Boolean, default: false },
  },

  computed: {
    froalaConfiguration() {
      return {
        attribution: false,
        key: 'none',
        pastePlain: true,
        toolbarStickyOffset: 64,
        language: 'cs',
        imageUploadURL: '',
        placeholderText: this.placeholder,
        events: {
          'image.uploaded': (response) => {
            this.$emit('image-uploaded', JSON.parse(response).filename);
          },
        },
        linkList: [],
        linkStyles: {},
        toolbarButtons: {
          moreText: {
            buttons: ['bold', 'italic'],
            buttonsVisible: 2,
          },
          moreParagraph: {
            buttons: ['formatOLSimple', 'formatUL', 'outdent', 'indent'],
            buttonsVisible: 4,
          },
          moreRich: {
            buttons: ['insertLink', 'emoticons'].concat(this.disableMultimedia ? [] : ['insertImage', 'insertVideo']),
            buttonsVisible: 4,
          },
          moreMisc: {
            buttons: ['undo', 'redo'],
            align: 'right',
            buttonsVisible: 2,
          },
        },
      };
    },
  },
};
</script>
