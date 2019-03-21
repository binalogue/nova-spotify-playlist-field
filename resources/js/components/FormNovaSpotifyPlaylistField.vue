<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <div class="mb-4">
        <label class="inline-block text-80 py-2 mr-4 leading-tight">
          Name
        </label>

        <input
          v-model="playlist.name"
          :class="errorClasses"
          type="text"
          placeholder="Name"
          class="w-full form-control form-input form-input-bordered"
        >
      </div>

      <div
        v-if="field.optionalParameters.includes('description')"
        class="mb-4"
      >
        <label class="inline-block text-80 py-2 mr-4 leading-tight">
          Description
        </label>

        <input
          v-model="playlist.description"
          :class="errorClasses"
          type="text"
          placeholder="Description"
          class="w-full form-control form-input form-input-bordered"
        >
      </div>

      <div
        v-if="field.optionalParameters.includes('public')"
        class="mb-4 flex items-center"
      >
        <label class="inline-block text-80 py-2 leading-tight">
          <input
            v-model="playlist.public"
            :class="errorClasses"
            class="mr-2"
            type="checkbox"
          >
          <span>
            Public
          </span>
        </label>
      </div>

      <div
        v-if="field.optionalParameters.includes('collaborative')"
        class="mb-4 flex items-center"
      >
        <label class="inline-block text-80 py-2 leading-tight">
          <input
            v-model="playlist.collaborative"
            :class="errorClasses"
            class="mr-2"
            type="checkbox"
          >
          <span>
            Collaborative
          </span>
        </label>
      </div>
    </template>
  </default-field>
</template>

<script>
/* eslint-disable vue/require-prop-types */

/* Vendor */
import { FormField, HandlesValidationErrors } from 'laravel-nova';

/* Services */
import { getPlaylist } from '../services/spotify';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  data() {
    return {
      // The Spotify playlist object.
      playlist: {
        name: '',
        public: true,
        collaborative: false,
        description: '',
      },
    };
  },

  methods: {
    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append('name', this.playlist.name || '');

      if (this.field.optionalParameters.includes('public')) {
        formData.append('public', this.playlist.public);
      }

      if (this.field.optionalParameters.includes('collaborative')) {
        formData.append('collaborative', this.playlist.collaborative);
      }

      if (this.field.optionalParameters.includes('description')) {
        formData.append('description', this.playlist.description);
      }
    },

    /**
     * Set the initial, internal value for the field.
     */
    async setInitialValue() {
      if (!this.field.playlistId) {
        return;
      }

      ({ data: this.playlist } = await getPlaylist(
        this.field.accessToken,
        this.field.userId,
        this.field.playlistId,
      ));
    },
  },
};
</script>
