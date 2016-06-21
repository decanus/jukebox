/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'
import { createObservable } from '../dom/events/create-observable'
import { getInterval } from '../dom/time/get-interval'
import { Observable } from '../observable'

/**
 *
 * @type {string}
 */
const IFRAME_API = 'https://www.youtube.com/iframe_api'

/**
 *
 * @returns {Promise}
 */
function loadYoutubeApi () {
  return new Promise((resolve) => {
    let $script = document.createElement('script')
    $script.src = IFRAME_API

    var $firstScript = document.querySelector('script')
    $firstScript.parentNode.insertBefore($script, $firstScript)

    window.onYouTubeIframeAPIReady = () => resolve()
  })
}

export class YoutubePlayer {
  constructor () {
    /**
     *
     * @type {Emitter}
     * @private
     */
    this._emitter = new Emitter()

    /**
     *
     * @type {Promise}
     * @private
     */
    this._ready = loadYoutubeApi()
      .then(() => {
        return new Promise((resolve) => {
          /**
           *
           * @type {YT.Player}
           * @private
           */
          this._player = new YT.Player('youtube-player', {
            height: '100%',
            width: '100%',
            events: {
              onReady: resolve
            },
            playerVars: {
              controls: 0,
              rel: 0,
              showinfo: 0,
              modestbranding: 1,
              disablekb: 0,
              autoplay: 0,
              autohide: 1,
              iv_load_policy: 3,
              playsinline: 1
            }
          })
        })
      })
  }

  /**
   *
   * @returns {Promise<YoutubePlayer>}
   */
  ready () {
    return this._ready
      .then(() => this)
  }

  /**
   *
   * @param track
   */
  setTrack (track) {
    this._player.loadVideoById(track.youtubeId)
  }

  /**
   *
   * @returns {Promise}
   */
  play () {
    let play = this.getPlay().once()

    if (this._player.getPlayerState() === YT.PlayerState.BUFFERING) {
      // we really don't want to wait for a play event
      // because this is gonna block our whole ui if the video is buffering
      this._emitter.emit('play')
    }

    this._player.playVideo()

    return play
  }

  /**
   *
   * @returns {Promise}
   */
  pause () {
    const state = this._player.getPlayerState()

    if (state !== YT.PlayerState.PLAYING && state !== YT.PlayerState.BUFFERING) {
      return Promise.resolve()
    }

    let pause = this.getPause().once()

    if (state === YT.PlayerState.BUFFERING) {
      // we really don't want to wait for a pause event
      // because this is gonna block our whole ui if the video is buffering
      this._emitter.emit('pause')
    }

    this._player.pauseVideo()

    return pause
  }

  /**
   * 
   * @returns {Promise}
   */
  stop() {
    let stopped = this._getStateChange()
      .filter((e) => e.data !== YT.PlayerState.PLAYING)
      .once()

    this._player.stopVideo()

    return stopped
  }

  /**
   *
   * @returns {Observable}
   */
  getEnd () {
    return this._getStateChange()
      .filter((e) => e.data === YT.PlayerState.ENDED)
  }

  /**
   *
   * @returns {Observable}
   */
  getPlay () {
    const play = this._getStateChange()
      .filter((e) => e.data === YT.PlayerState.PLAYING)

    return Observable.merge(play, this._emitter.toObservable('play'))
  }

  /**
   *
   * @returns {Observable}
   */
  getPause () {
    const pause = this._getStateChange()
      .filter((e) => e.data === YT.PlayerState.PAUSED)

    return Observable.merge(pause, this._emitter.toObservable('pause'))
  }

  /**
   *
   * @returns {Observable<number>}
   */
  getPosition () {
    return getInterval(100)
      .map(() => this._player.getCurrentTime())
  }

  /**
   *
   * @returns {Observable<number>}
   */
  getDuration () {
    return this.getPlay().map(() => this._player.getDuration())
  }

  /**
   *
   * @returns {number}
   */
  getVolume () {
    return this._player.getVolume()
  }

  /**
   *
   * @param {number} volume
   */
  setVolume (volume) {
    this._player.setVolume(volume)
  }

  /**
   *
   * @param {number} value
   */
  setPosition (value) {
    this._player.seekTo(value, true)
  }

  /**
   *
   * @returns {Observable}
   * @private
   */
  _getStateChange () {
    return createObservable(this._player, 'onStateChange')
  }
}
