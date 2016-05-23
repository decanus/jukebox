import { Emitter } from '../../event/emitter'
import { Communicator } from './communicator'

/**
 *
 * @param {{}} data
 * @returns {{title: string, duration: number}}
 */
function mapTracksFromData (data) {
  let track = data.tracks[ 0 ]

  return {
    title: track.title,
    duration: Number(track.duration),
    artwork: `https://api.deezer.com/album/${track.album.id}/image`
  }
}

export class DeezerPlayer extends Emitter {
  /**
   *
   * @param {string} appId
   */
  constructor (appId) {
    super()

    /**
     *
     * @type {Communicator}
     * @private
     */
    this._communicator = new Communicator(appId)

    this.getTrack().forEach((track) => {
      /**
       *
       * @type {number}
       * @private
       */
      this._duration = track.duration
    })
  }

  /**
   *
   * @returns {Promise}
   */
  ready () {
    return this._communicator
      .ready()
      .then(() => this)
  }

  /**
   *
   * @param {string} trackId
   * @returns {Promise}
   */
  playTrack (trackId) {
    this._communicator.sendMethod('DZ.player_controler.playTracks', {
      trackList: trackId,
      index: 0,
      autoplay: true,
      offset: 0
    })

    return this.getPlay().once()
  }

  /**
   *
   * @param {string} trackId
   * @returns {Promise}
   */
  preloadTrack (trackId) {
    this._communicator.sendMethod('DZ.player_controler.playTracks', {
      trackList: trackId,
      index: 0,
      autoplay: false,
      offset: 0
    })

    return this.getTrack().once()
  }

  /**
   *
   * @returns {Promise}
   */
  play () {
    this._communicator.sendCommand('play')

    return this.getPlay().once()
  }

  /**
   *
   * @returns {Promise}
   */
  pause () {
    this._communicator.sendCommand('pause')

    return this.getPause().once()
  }

  /**
   *
   * @param {number} value
   */
  setVolume (value) {
    return this._communicator.sendCommand('setVolume', value)
  }

  /**
   *
   * @param {boolean} mute
   */
  setMute (mute) {
    return this._communicator.sendCommand('setVolume', mute)
  }

  /**
   *
   * @returns {Observable<undefined>}
   */
  getEnd () {
    return this._communicator
      .getEvents()
      .filter((args) => args.evt === 'TRACK_END')
      .map(() => {})
  }

  /**
   *
   * @returns {Observable}
   */
  getPlay () {
    return this._communicator
      .getEvents()
      .filter((args) => args.evt === 'PLAY')
      .map(() => {})
  }

  /**
   *
   * @returns {Observable}
   */
  getPause () {
    return this._communicator
      .getEvents()
      .filter((args) => args.evt === 'PAUSED')
      .map(() => {})
  }

  /**
   *
   * @returns {Observable<number>}
   */
  getPosition () {
    return this._communicator
      .getEvents()
      .filter((args) => args.evt === 'POSITION_CHANGED')
      .map((args) => args.val[ 0 ])
      .distinct()
  }

  /**
   *
   * @returns {Observable}
   */
  getTrack () {
    return this._communicator
      .getEvents()
      .filter((args) => args.evt === 'TRACKS_LOADED')
      .map((args) => mapTracksFromData(args.val))
  }

  /**
   *
   * @param {number} value
   */
  setPosition (value) {
    this._communicator.sendCommand('seek', 100 / this._duration * value / 100)
  }
}
