/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Artist {
  /**
   *
   * @param {number} id
   * @param {string} name
   * @param {string} permalink
   */
  constructor ({ id, name, permalink}) {
    this.id = id
    this.name = name
    this.permalink = permalink

    Object.freeze(this)
  }

  /**
   * 
   * @returns {string}
   */
  get type() {
    return 'artists'
  }
}
