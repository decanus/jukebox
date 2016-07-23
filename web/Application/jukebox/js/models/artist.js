/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */
  
export class Artist {
  /**
   *
   * @param {number} id
   * @param {string} name
   * @param {string} permalink
   * @param {ArtistImage} image
   */
  constructor ({ id, name, permalink, image }) {
    this.id = id
    this.name = name
    this.permalink = permalink
    this.image = image

    Object.freeze(this)
  }

  /**
   * 
   * @returns {string}
   */
  get type() {
    return 'artists'
  }

  /**
   * 
   * @returns {boolean}
   */
  get isArtist () {
    return true
  }
}
