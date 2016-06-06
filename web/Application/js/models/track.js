/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {Artist} artist
   * @param {YoutubeTrack} [youtubeTrack]
   */
  constructor ({ id, title, artist }, { youtubeTrack }) {
    this.id = id
    this.title = title
    this.artist = artist
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
