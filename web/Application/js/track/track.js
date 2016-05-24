export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {string} artist
   * @param {string} youtubeId
   * @param {number} duration
   */
  constructor(id, title, artist, {youtubeId, duration}) {
    this.id = id
    this.title = title
    this.artist = artist
    this.youtubeId = youtubeId
    this.duration = duration

    Object.freeze(this)
  }
}
