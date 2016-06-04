/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'
import { createObservable } from '../dom/events/create-observable'
import { getInterval } from '../time/get-interval'
import { Track } from '../track/track'

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

export class YoutubePlayer extends Emitter {
  constructor () {
    super()

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

    this._player.playVideo()

    return play
  }

  /**
   *
   * @returns {Promise}
   */
  pause () {
    if (this._player.getPlayerState() !== YT.PlayerState.PLAYING) {
      return Promise.resolve()
    }

    let pause = this.getPause().once()

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
    return this._getStateChange()
      .filter((e) => e.data === YT.PlayerState.PLAYING)
  }

  /**
   *
   * @returns {Observable}
   */
  getPause () {
    return this._getStateChange()
      .filter((e) => e.data === YT.PlayerState.PAUSED)
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
