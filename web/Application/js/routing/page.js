/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Page {
  /**
   *
   * @param {string} title
   * @param {string} template
   * @param {{}} data
   * @param {bool} showSidebar
   */
  constructor({title, template, data = {}, showSidebar = true}) {
    this.title = title
    this.template = template
    this.data = data
    this.showSidebar = true

    Object.freeze(this)
  }
}
