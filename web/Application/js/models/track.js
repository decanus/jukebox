/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @todo add multiple artists, primary artist
 */
export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {Artist} artist
   * @param {string} permalink
   * @param {YoutubeTrack} [youtubeTrack]
   */
  constructor ({ id, title, artist, permalink }, { youtubeTrack }) {
    this.id = id
    this.title = title
    this.artist = artist
    this.permalink = permalink
    this.youtubeTrack = youtubeTrack

    Object.freeze(this)
  }

  /**
   *
   * @returns {string}
   */
  get type() {
    return 'tracks'
  }
}
