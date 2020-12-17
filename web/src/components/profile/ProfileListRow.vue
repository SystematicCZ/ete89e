<template>
  <div class="d-flex flex-row border-bottom p-3 profile-row">
    <div
    >
      <img
        :src="user.profilePicture"
        class="rounded-circle profile-image mr-4"
        width="70"
      >
    </div>
    <div class="my-auto flex-grow-1">
      <p class="mb-0">
        {{ user.fullName }}
        <br>
        <span class="text-secondary">{{ user.email }}</span>
      </p>
    </div>
    <div class="text-right my-auto">
      <b-button
        :id="`profile_card_${user.id}`"
        variant="outline-warning"
      >
        <b-icon icon="search"/>
        Detail
      </b-button>
      <b-button
        v-b-modal="`contact_modal_${user.id}`"
        variant="outline-primary"
      >
        <b-icon icon="envelope"/>
        Napsat
      </b-button>
    </div>
    <b-popover
      :target="`profile_card_${user.id}`"
      triggers="hover"
      placement="left"
    >
      <profile-card
        :user="user"
      />
    </b-popover>
    <b-modal
      :id="`contact_modal_${user.id}`"
      :title="`Kontaktovat ${user.fullName}`"
      centered
      hide-footer
    >
      <input-wrapper
        label="Text zprávy"
      >
        <input-textarea
          value=""
        />
      </input-wrapper>

      <div class="text-center">
        <b-button
          variant="primary"
          @click="$bvModal.hide(`contact_modal_${user.id}`); $toasted.success('Zpráva odeslána')"
        >
          Odeslat
        </b-button>
      </div>
    </b-modal>
  </div>
</template>
<script>
import ProfileCard from './ProfileCard.vue';
import InputWrapper from '../forms/InputWrapper.vue';
import InputTextarea from '../forms/InputTextarea.vue';

export default {
  components: { InputTextarea, InputWrapper, ProfileCard },
  props: {
    user: { type: Object, required: true },
  },
};
</script>
<style scoped lang="scss">
.profile-row:hover {
 background-color: $color-shades-light;
}
</style>
