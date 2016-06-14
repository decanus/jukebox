/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */
  
import { parseUrl } from '../url/parse'

export class Artist {
  /**
   *
   * @param {number} id
   * @param {string} name
   * @param {string} permalink
   * @param {string} website
   * @param {string} facebook
   * @param {string} twitter
   */
  constructor ({ id, name, permalink, website, facebook, twitter }) {
    this.id = id
    this.name = name
    this.permalink = permalink
    this.website = website
    this.facebook = facebook
    this.twitter = twitter

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
  get websiteName () {
    return parseUrl(this.website).host
  }
}
