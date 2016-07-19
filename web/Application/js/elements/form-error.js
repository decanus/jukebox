/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import errors from '../../data/labels/form-errors.json'

export class FormError extends HTMLElement {
  /**
   *
   * @param {string} error
   */
  set errorCode (error) {
    this.setAttribute('error-code', error)
  }

  /**
   *
   * @returns {string}
   */
  get errorCode () {
    return this.getAttribute('error-code')
  }

  clear () {
    this.textContent = ''
  }

  createdCallback () {
    this._render()
  }

  attributeChangedCallback (name) {
    if (name === 'error-code') {
      this._render()
    }
  }

  _render () {
    this.textContent = errors[ this.errorCode ]
  }
}
