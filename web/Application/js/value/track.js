export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {string} youtubeId
   */
  constructor(id, title, {youtubeId}) {
    this.id = id
    this.title = title
    this.youtubeId = youtubeId

    Object.freeze(this)
  }
}
