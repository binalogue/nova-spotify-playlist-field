<template>
  <div v-if="playlist">
    <div class="flex border-b border-40 remove-bottom-border">
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          ID
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <p>
          {{ playlist.id || '-' }}
        </p>
      </div>
    </div>

    <div class="flex border-b border-40 remove-bottom-border">
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          Name
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <p>
          {{ playlist.name || '-' }}
        </p>
      </div>
    </div>

    <div
      v-if="field.optionalParameters.includes('description')"
      class="flex border-b border-40 remove-bottom-border"
    >
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          Description
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <p>
          {{ playlist.description || '-' }}
        </p>
      </div>
    </div>

    <div class="flex border-b border-40 remove-bottom-border">
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          Spotify URL
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <a
          :href="playlist.external_urls.spotify"
          target="blank"
          class="flex items-center no-underline font-bold dim text-success"
        >
          <span class="mr-2">
            {{ playlist.external_urls.spotify }}
          </span>

          <icon-external-link class="w-4"/>
        </a>
      </div>
    </div>

    <div
      v-if="field.optionalParameters.includes('public')"
      class="flex border-b border-40 remove-bottom-border"
    >
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          Public
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <p>
          {{ playlist.public || '-' }}
        </p>
      </div>
    </div>

    <div
      v-if="field.optionalParameters.includes('collaborative')"
      class="flex border-b border-40 remove-bottom-border"
    >
      <div class="w-1/4 py-4">
        <h4 class="font-normal text-80">
          Collaborative
        </h4>
      </div>

      <div class="w-3/4 py-4">
        <p>
          {{ playlist.collaborative || '-' }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
/* Services */
import { getPlaylist } from '../services/spotify';

/* Components */
import IconExternalLink from './icons/IconExternalLink.vue';

export default {
  components: {
    IconExternalLink,
  },

  props: ['resource', 'resourceName', 'resourceId', 'field'],

  data() {
    return {
      // The Spotify playlist object.
      playlist: null,
    };
  },

  async created() {
    ({ data: this.playlist } = await getPlaylist(
      this.field.accessToken,
      this.field.userId,
      this.field.playlistId,
    ));
  },
};
</script>
