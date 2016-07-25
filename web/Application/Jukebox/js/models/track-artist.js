/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * Todo: does not belong into /model, -> /value
 */
export class TrackArtist {
  /**
   *
   * @param {string} role
   * @param {Artist} artist
   * @param {number} index
   */
  constructor (role, artist, index) {
    this.role = role
    this.artist = artist
    this.index = index

    Object.freeze(this)
  }

  /**
   *
   * @returns {boolean}
   */
  get isFeatured () {
    return this.role === 'featured'
  }

  /**
   *
   * @returns {boolean}
   */
  get isMain () {
    return this.role === 'main'
  }

  /**
   *
   * @returns {boolean}
   */
  get isPrependComma () {
    return this.index !== 0 && this.isMain
  }
}

