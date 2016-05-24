export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {string} artist
   * @param {string} youtubeId
   */
  constructor(id, title, artist, {youtubeId}) {
    this.id = id
    this.title = title
    this.artist = artist
    this.youtubeId = youtubeId

    Object.freeze(this)
  }
}
