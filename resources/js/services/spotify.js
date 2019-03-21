/* global axios */

const transformRequest = [(data, headers) => {
  delete headers.common['X-Requested-With'];
  delete headers.common['X-CSRF-TOKEN'];
  return data;
}];

/**
 * Get a playlist.
 *
 * Get a playlist owned by a Spotify user.
 *
 * GET https://api.spotify.com/v1/users/{user_id}/playlists/{playlist_id}
 */
export const getPlaylist = (accessToken, userId, playlistId) => axios({
  url: `https://api.spotify.com/v1/users/${userId}/playlists/${playlistId}`,
  method: 'get',
  transformRequest,
  headers: {
    Authorization: `Bearer ${accessToken}`,
  },
});

export default {
  getPlaylist,
};
