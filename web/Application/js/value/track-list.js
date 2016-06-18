/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class TrackList {
  /**
   *
   * @param {Array<Track>} [tracks]
   */
  constructor (tracks = []) {
    this._tracks = tracks
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
    return this._tracks[ index ]
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
    const index = -1

    const tracks = this._tracks
      .map(($track, $idx) => ({ $track, $idx }))
      .filter(({ $track }) => $track.id === track.id)

    if (tracks.length === 0) {
      return -1
    }

    return tracks[0].$idx
  }

  /**
   *
   * @param {number} id
   * @returns {Array<Track>}
   * @private
   */
  _getTracksById (id) {
    return this._tracks.filter(($track) => $track.id === id)
  }

  /**
   * 
   * @returns {Number}
   */
  get size () {
    return this._tracks.length
  }
}
