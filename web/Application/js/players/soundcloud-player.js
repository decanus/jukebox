/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'
import { createPromise } from '../dom/events/create-promise'
import { createObservable } from '../dom/events/create-observable'

/**
 *
 * @type {string}
 */
const API_URL = 'https://api.soundcloud.com'

/**
 *
 * @param {string} trackId
 * @param {string} clientId
 */
function fetchTrackInfo (trackId, clientId) {
  var url = API_URL + '/tracks/' + encodeURIComponent(trackId) + '?client_id=' + encodeURIComponent(clientId)

  return fetch(url)
    .then(function (resp) {
      return resp.json()
    })
}

export class SoundcloudPlayer extends Emitter {
  /**
   *
   * @param {string} clientId
   */
  constructor (clientId) {
    super()

    /**
     *
     * @type {string}
     */
    this.clientId = clientId

    /**
     *
     * @type {HTMLAudioElement}
     * @private
     */
    this._audio = document.createElement('audio')

    /**
     *
     * @type {number}
     * @private
     */
    this._duration = 0
  }

  /**
   *
   * @returns {Promise}
   */
  ready () {
    return Promise.resolve(this)
  }

  /**
   *
   * @param {string} trackId
   * @returns {Promise}
   */
  playTrack (trackId) {
    let info = fetchTrackInfo(trackId, this.clientId)

    let audioLoaded = info
      .then((info) => {
        this._audio.src = info[ 'stream_url' ] + '?client_id=' + encodeURIComponent(this.clientId)

        return createPromise(this._audio, 'loadedmetadata')
      })

    return Promise.all([ info, audioLoaded ])
      .then((data) => {
        let info = data[ 0 ]

        this.emit('track', {
          title: info[ 'title' ],
          duration: this._audio.duration,
          artwork: info[ 'artwork_url' ]
        })

        return this.play()
      })
  }

  /**
   *
   * @param {string} trackId
   * @returns {Promise}
   */
  preloadTrack (trackId) {
    return this
      .playTrack(trackId)
      .then(() => this.pause())
  }

  /**
   *
   * @returns {Promise}
   */
  play () {
    this._audio.play()

    return createPromise(this._audio, 'play')
  }

  /**
   *
   * @returns {Promise}
   */
  pause () {
    if (this._audio.paused) {
      return Promise.resolve()
    }

    this._audio.pause()

    return createPromise(this._audio, 'pause')
  }

  /**
   *
   * @returns {Observable}
   */
  getEnd () {
    return createObservable(this._audio, 'ended')
  }

  /**
   *
   * @returns {Observable}
   */
  getPlay () {
    return createObservable(this._audio, 'play')
  }

  /**
   *
   * @returns {Observable}
   */
  getPause () {
    return createObservable(this._audio, 'pause')
  }

  /**
   *
   * @returns {Observable<number>}
   */
  getPosition () {
    return createObservable(this._audio, 'timeupdate')
      .map((e) => this._audio.currentTime)
  }

  /**
   *
   * @returns {Observable}
   */
  getTrack () {
    return Emitter.toObservable(this, 'track')
  }

  /**
   *
   * @param {number} value
   */
  setPosition (value) {
    this._audio.currentTime = value
  }
}
