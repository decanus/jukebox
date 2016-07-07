/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import errors from '../../data/labels/form-errors.json'

export class AjaxForm extends HTMLFormElement {
  attachedCallback () {
    this.addEventListener('submit', async (event) => {
      event.preventDefault()

      this._setError('')

      const response = await fetch(this.action, {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin'
      })

      const data = await response.json()

      if (data.error) {
        this._setErrorCode(data.error)
      }
    })
  }

  /**
   *
   * @param {string} code
   * @private
   */
  _setErrorCode (code) {
    this._setError(errors[ code ])
  }

  /**
   *
   * @param {string} error
   * @private
   */
  _setError (error) {
    const $error = this.$error

    if ($error == null) {
      return
    }

    $error.textContent = error
  }

  /**
   *
   * @returns {Element}
   */
  get $error () {
    return this.querySelector('form-error')
  }
}
