/* eslint-disable global-require, no-undef */

Nova.booting((Vue) => {
  Vue.config.devtools = true;
  Vue.config.debug = true;
  Vue.config.silent = false;
  Vue.config.productionTip = true;
  Vue.component('index-nova-spotify-playlist-field', require('./components/IndexNovaSpotifyPlaylistField'));
  Vue.component('detail-nova-spotify-playlist-field', require('./components/DetailNovaSpotifyPlaylistField'));
  Vue.component('form-nova-spotify-playlist-field', require('./components/FormNovaSpotifyPlaylistField'));
});
