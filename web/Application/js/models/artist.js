/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */
  
export class Artist {
  /**
   *
   * @param {number} id
   * @param {string} name
   * @param {string} permalink
   * @param {string} website
   * @param {string} facebook
   * @param {string} twitter
   * @param {string} image
   */
  constructor ({ id, name, permalink, website, facebook, twitter, image }) {
    this.id = id
    this.name = name
    this.permalink = permalink
    this.website = website
    this.facebook = facebook
    this.twitter = twitter
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

  /**
   * 
   * @returns {string}
   */
  get twitterUrl () {
    return `https://twitter.com/${this.twitter}`
  }

  /**
   * 
   * @returns {string}
   */
  get imageUrl () {

    if (this.image == null) {
      return '/images/artists/default.png'
    }

    return `/images/artists/${this.image}`
  }
}
