/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ModelRepository {
  /**
   *
   * @param {ModelStore} store
   * @param {ModelFetcher} fetcher
   * @param {ModelLoader} loader
   */
  constructor (store, fetcher, loader) {
    this._store = store
    this._fetcher = fetcher
    this._loader = loader
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Promise<{ type: string, id: number }>}
   */
  get ({ type, id }) {
    const key = { type, id }

    if (this._store.has(key)) {
      return Promise.resolve(this._store.get(key))
    }

    return this._fetcher
      .fetch(key)
      .then((data) => this._loader.load(data))
  }

  /**
   *
   * @param {string} query
   * @returns {Promise<Result>}
   * @deprecated
   * @see getResult
   */
  getResults (query) {
    return this.get({ id: query, type: 'results' })
  }

  /**
   *
   * @param {ResultId} id
   * @returns {Promise<Result>}
   */
  getResult (id) {
    return this.get({ id, type: 'results' })
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<Track>}
   */
  getTrack (id) {
    return this.get({ id, type: 'tracks' })
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<Artist>}
   */
  getArtist (id) {
    return this.get({ id, type: 'artists' })
  }

  /**
   *
   * @param {number} id
   * @returns {Promise<ArtistImage>}
   */
  getArtistImage (id) {
    return this.get({ id, type: 'artist-images' })
  }

  /**
   *
   * @param {ResultId} artistId
   */
  getArtistTracks (artistId) {
    return this.get({ id: artistId, type: 'artist-tracks' })
  }

  /**
   *
   * @param {number} artistId
   * @returns {Promise<ArtistProfiles>}
   */
  getArtistProfiles (artistId) {
    return this.get({ id: artistId, type: 'artist-profiles' })
  }

  /**
   *
   * @param {{ type: string, id: number }} model
   * @returns {{ type: string, id: number }}
   */
  add (model) {
    return this._loader.load(model)
  }

  /**
   *
   * @param {string} type
   * @param {number} id
   * @returns {Function}
   */
  hold ({ type, id }) {
    const key = { type, id }

    this._store.hold(key)

    return () => {
      this._store.release(key)
    }
  }

  cleanup () {
    this._store.cleanup()
  }

  registerCleanupInterval () {
    setInterval(this.cleanup.bind(this), 180000)
  }
}
