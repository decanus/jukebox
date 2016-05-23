//import { PlayerFactory } from './player-factory'
import { YoutubePlayer } from './youtube-player'
import { Emitter } from '../event/emitter'
import { Observable } from '../observable'
import { PlayerState } from './player-state'

/**
 *
 * @param {string} method
 */
function delegateToCurrentPlayer (method) {
  return new Observable((observer) => {
    let subscription

    this.getTrackUpdate().forEach(() => {
      if (subscription) {
        subscription.unsubscribe()
      }

      subscription = this.currentPlayer[ method ]()
        .subscribe({
          next: (value) => observer.next(value),
          error: (error) => observer.error(error)
        })
    })

    return () => {
      if (!subscription) {
        return
      }

      subscription.unsubscribe()
    }
  })
}

export class PlayerDelegate extends Emitter {
  /**
   *
   * @param {Array<Track>} tracks
   */
  constructor (tracks = []) {
    super()

    /**
     *
     * @type {Array<Track>}
     * @private
     */
    this._tracks = []

    /**
     *
     * @type {YoutubePlayer}
     * @private
     */
    this._youtubePlayer = new YoutubePlayer()

    /**
     *
     * @type {number}
     * @private
     */
    this._current = null

    tracks.forEach((track) => {
      this.addTrack(track)
    })
  }

  /**
   *
   * @returns {Promise<void>}
   */
  play () {
    if (this._tracks.length < 1) {
      return Promise.resolve()
    }

    if (this._current === null) {
      return this.next()
    }

    return this.currentPlayer.play()
  }

  /**
   *
   * @returns {Promise<void>}
   */
  pause () {
    if (this._current === null) {
      return Promise.resolve()
    }

    return this.currentPlayer
      .ready()
      .then((player) => player.pause())
  }

  /**
   *
   * @param {number} update
   * @returns {Promise}
   * @private
   */
  _changeCurrent (update) {
    if (this._current === null) {
      return this._playTrack(0)
    }

    return this._playTrack(this._current + update)
  }

  /**
   *
   * @param {number} index
   * @returns {Promise}
   * @private
   */
  _playTrack (index) {
    let pause = this.pause()

    if (index < 0 || index > this._tracks.length - 1) {
      this._current = null
      return Promise.resolve()
    }

    this._current = index

    return pause
    // wait for the api to be ready
      .then(() => this.currentPlayer.ready())
      .then(() => this.emit('trackUpdate', this._current))
      .then(() => this.emit('playerState', PlayerState.LOADING))
      // todo: make this non-youtube specific
      .then(() => this.currentPlayer.playTrack(this.currentTrack.youtubeId))
      // wait for end
      .then(() => {
        let cancelled = false

        this.getTrackUpdate().once().then(() => {
          cancelled = true
        })

        this.currentPlayer
          .getEnd()
          .once()
          .then(() => {
            if (cancelled) {
              return
            }

            this.next()
          })
      })
  }

  /**
   *
   * @returns {Promise<void>}
   */
  next () {
    return this._changeCurrent(1)
  }

  /**
   *
   * @returns {Promise<void>}
   */
  prev () {
    return this._changeCurrent(-1)
  }

  /**
   *
   * @returns {Promise<void>}
   */
  stop () {
    return this.pause()
      .then(() => {
        this._current = null
      })
  }

  /**
   *
   * @param {Track} track
   */
  addTrack (track) {
    this._tracks.push(track)
  }

  /**
   *
   * @returns {Observable}
   */
  getTrackUpdate () {
    return Emitter.toObservable(this, 'trackUpdate')
  }

  /**
   *
   * @returns {Observable}
   */
  getPosition () {
    return delegateToCurrentPlayer.call(this, 'getPosition')
  }

  /**
   *
   * @param {number} value
   */
  setPosition (value) {
    this.currentPlayer.setPosition(value)
  }

  /**
   *
   * @returns {Observable}
   */
  getTrack () {
    return delegateToCurrentPlayer.call(this, 'getTrack')
      .map((track) => {
        track.service = this.currentTrack.service

        return track
      })
  }

  /**
   *
   * @returns {Observable}
   */
  getPlay () {
    return delegateToCurrentPlayer.call(this, 'getPlay')
  }

  /**
   *
   * @returns {Observable}
   */
  getPause () {
    return delegateToCurrentPlayer.call(this, 'getPause')
  }

  /**
   *
   * @returns {Observable}
   */
  getStop () {
    return this.getState().filter((value) => value === PlayerState.STOPPED)
  }

  /**
   *
   * @returns {Observable}
   */
  getLoading () {
    return this.getState().filter((value) => value === PlayerState.LOADING)
  }

  /**
   *
   * @returns {Observable}
   */
  getState () {
    let play = this.getPlay().map(() => PlayerState.PLAYING)
    let pause = this.getPause().map(() => PlayerState.PAUSED)
    let loading = Emitter.toObservable(this, 'playerState')

    return Observable.merge(loading, play, pause)
  }

  /**
   *
   * @returns {Promise}
   */
  preload () {
    return this.play()
      .then(() => this.pause())
  }

  /**
   *
   * @returns {Track}
   */
  get currentTrack () {
    return this._tracks[ this._current ]
  }

  /**
   * @todo implement
   * @returns {YoutubePlayer}
   */
  get currentPlayer () {
    //return factory.getPlayer(this.currentTrack.service)
    return this._youtubePlayer
  }
}
