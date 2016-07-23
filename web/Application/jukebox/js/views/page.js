/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @todo this needs to be renamed
 */
export class Page {
  /**
   *
   * @param {string} title
   * @param {string} template
   * @param {{}} data
   */
  constructor({title, template, data = {}}) {
    this.title = title
    this.template = template
    this.data = data

    Object.freeze(this)
  }
}
