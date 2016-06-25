/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class TabContent extends HTMLElement {
  /**
   *
   * @returns {string}
   */
  get tabName () {
    return this.getAttribute('tab-name')
  }

  /**
   * 
   * @returns {string}
   */
  get tabGroup () {
    return this.getAttribute('tab-group')
  }

  /**
   *
   * @returns {boolean}
   */
  get hidden () {
    return this.hasAttribute('hidden')
  }

  /**
   *
   * @param {boolean} value
   */
  set hidden(value) {
    if (value) {
      this.setAttribute('hidden', 'hidden')
    } else {
      this.removeAttribute('hidden')
    }
  }
}
