<?php

namespace Binalogue\SpotifyPlaylistField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class SpotifyPlaylistField extends Field
{
    /*
    |--------------------------------------------------------------------------
    | Field Properties
    |--------------------------------------------------------------------------
    */

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-spotify-playlist-field';

    /**
     * The Spotify API optional parameters.
     */
    public $defaultOptionalParameters = [
        'public',
        'collaborative',
        'description',
    ];

    /**
     * Hydrate the given attributes on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request,
        $requestAttribute, $model, $attribute)
    {
        // Required parameters.

        $model->spotifyApiName = $request->exists('name')
            ? $request['name']
            : 'Playlist name';

        // Optional parameters.

        collect($request)
            ->only($this->meta['optionalParameters'])
            ->only($this->defaultOptionalParameters)
            ->each(function ($value, $key) use ($model) {
                $ucfirstKey = ucfirst($key);
                $model->{"spotifyApi{$ucfirstKey}"} = $value;
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Field Meta
    |--------------------------------------------------------------------------
    */

    /**
     * Set the Spotify access token.
     *
     * @param  string|null  $refreshToken
     * @return $this
     */
    public function accessToken($refreshToken = null)
    {
        if (is_null($refreshToken)) {
            return $this;
        }

        $spotify = app()->make('SpotifyWrapper');
        $spotify->session->refreshAccessToken($refreshToken);

        return $this->withMeta([
            'accessToken' => $spotify->session->getAccessToken(),
        ]);
    }

    /**
     * Set the Spotify user ID.
     *
     * @param  string|null  $userId
     * @return $this
     */
    public function userId($userId)
    {
        if (is_null($userId)) {
            return $this;
        }

        return $this->withMeta([
            'userId' => $userId,
        ]);
    }

    /**
     * Set the Spotify playlist ID.
     *
     * @param  string|null  $playlistId
     * @return $this
     */
    public function playlistId($playlistId)
    {
        if (is_null($playlistId)) {
            return $this;
        }

        return $this->withMeta([
            'playlistId' => $playlistId,
        ]);
    }

    /**
     * Set the optional Spotify API parameters.
     *
     * @param  array|null  $parameters
     * @return $this
     */
    public function optionalParameters($parameters)
    {
        return $this->withMeta([
            'optionalParameters' => $parameters ?: $this->defaultOptionalParameters,
        ]);
    }
}
