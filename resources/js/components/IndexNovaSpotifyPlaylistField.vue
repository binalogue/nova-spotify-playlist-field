<template>
  <div v-if="playlist" class="flex flex-col">
    <a
      :href="playlist.external_urls.spotify"
      target="blank"
      class="flex items-center no-underline font-bold dim text-success"
    >
      <span class="mr-2">
        {{ playlist.name }}
      </span>

      <icon-external-link class="w-4"/>
    </a>

    <span class="text-xs">
      ID: {{ playlist.id }}
    </span>
  </div>

  <span v-else>
    -
  </span>
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

  props: ['resourceName', 'field'],

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
