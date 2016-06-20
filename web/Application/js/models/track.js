/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Track {
  /**
   *
   * @param {number} id
   * @param {string} title
   * @param {Array<TrackArtist>} artists
   * @param {string} permalink
   * @param {boolean} isExplicit
   * @param {boolean} isMusicVideo
   * @param {boolean} isLive
   * @param {YoutubeTrack} [youtubeTrack]
   */
  constructor ({ id, title, artists, permalink, isExplicit = false, isMusicVideo = false, isLive = false }, { youtubeTrack }) {
    this.id = id
    this.title = title
    this.artists = artists
    this.permalink = permalink
    this.youtubeTrack = youtubeTrack
    this.isExplicit = isExplicit
    this.isMusicVideo = isMusicVideo
    this.isLive = isLive

    Object.freeze(this)
  }

  /**
   *
   * @returns {string}
   */
  get type () {
    return 'tracks'
  }

  /**
   *
   * @returns {boolean}
   */
  get isTrack () {
    return true
  }

  /**
   *
   * @returns {string}
   */
  get artistsString () {
    return (
      this.artists
        .map((artist, i) => {
          const name = artist.artist.name

          if (artist.isFeatured) {
            return ` feat. ${name}`
          }

          if (i !== 0) {
            return `, ${name}`
          }

          return name
        })
        .join('')
    )
  }
}
