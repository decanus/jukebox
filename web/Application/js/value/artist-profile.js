/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ArtistProfile {

  /**
   *
   * @param {string} type
   * @param {string} data
   */
  constructor (type, data) {
    this.type = type
    this.data = data
  }

  /**
   *
   * @returns {string}
   */
  get label () {
    switch (this.type) {
      case 'official_website':
        return 'Official Website'
      case 'twitter':
        return `@${this.data}`
    }
  }

  /**
   *
   * @returns {string}
   */
  get icon () {
    if (this.type === 'official_website') {
      return 'link'
    }

    return this.type
  }

  /**
   *
   * @returns {string}
   */
  get url () {
    switch(this.type) {
      case 'official_website':
        return this.data
      case 'twitter':
        return `https://twitter.com/${this.data}`
    }
  }
}
