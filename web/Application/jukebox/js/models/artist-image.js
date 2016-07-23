/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ArtistImage {
  /**
   *
   * @param {number} id
   * @param {string} name
   */
  constructor ({ id, name }) {
    this.id = id
    this.name = name

    Object.freeze(this)
  }

  /**
   *
   * @returns {string}
   */
  get type() {
    return 'artist-images'
  }
  
  /**
   *
   * @returns {string}
   */
  get imageUrl () {

    if (this.name == null) {
      return '/images/artists/default.png'
    }

    return `/images/artists/${this.name}`
  }
}
