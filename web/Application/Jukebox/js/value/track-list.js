/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class TrackList {
  /**
   *
   * @param {Array<Track>} [tracks]
   */
  constructor (tracks = []) {
    this._tracks = []

    tracks.forEach((track) => this.append(track))
  }

  /**
   *
   * @param {Result} result
   * @returns {TrackList}
   */
  static fromResult (result) {
    const tracks = result.results
      .filter(($model) => $model.type === 'tracks')

    return new TrackList(tracks)
  }

  /**
   *
   * @param {number} index
   * @returns {Track}
   */
  get (index) {
    return this._tracks[ index ] && this._tracks[ index ].track
  }

  /**
   *
   * @param {Track} track
   */
  append (track) {
    this._tracks.push({
      track,
      cleanup: app.modelRepository.hold(track, this)
    })
  }

  removeLast () {
    const { cleanup } = this._tracks.pop()
    
    cleanup()
  }

  removeFirst () {
    const { cleanup } = this._tracks.shift()

    cleanup()
  }

  /**
   *
   * @param {Track} track
   * @returns {boolean}
   */
  containsTrack (track) {
    return this._getTracksById(track.id).length > 0
  }

  /**
   *
   * @param {Track} track
   * @returns {number}
   */
  indexOfTrack (track) {
    const result = this.tracks
      .map(($track, $idx) => ({ $track, $idx }))
      .find(({ $track }) => $track.id === track.id)

    if (result == null) {
      return -1
    }

    return result.$idx
  }

  cleanup () {
    this._tracks.forEach((item) => {
      item.cleanup()
    })

    this._tracks = []
  }

  /**
   *
   * @param {number} id
   * @returns {Array<Track>}
   * @private
   */
  _getTracksById (id) {
    return this.tracks.filter(($track) => $track.id === id)
  }

  /**
   *
   * @returns {Array<Track>}
   */
  get tracks () {
    return this._tracks.map(({ track }) => track)
  }

  /**
   *
   * @returns {Number}
   */
  get size () {
    return this._tracks.length
  }
}
