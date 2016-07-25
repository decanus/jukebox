/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @typedef {{ handle: (function(data: {})) }} FormHandler
 */


import { locateHandler } from '../form/locate-handler'

export class AjaxForm extends HTMLFormElement {
  attachedCallback () {
    this.addEventListener('submit', async (event) => {
      event.preventDefault()

      this._$error.clear()

      const response = await fetch(this.action, {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin',
        body: new FormData(this)
      })

      const data = await response.json()

      if (data.error) {
        this._$error.errorCode = data.error
        return
      }

      if (data.message) {
        this._$error.errorCode = data.message
      }
      
      const handler = this._formHandler
      
      if (handler) {
        handler.handle(data)
      }
    })
  }

  /**
   *
   * @returns {FormError}
   */
  get _$error () {
    return this.querySelector('form-error')
  }

  /**
   *
   * @returns {FormHandler}
   * @private
   */
  get _formHandler () {
    const Handler = locateHandler(this.getAttribute('form-handler'))

    if (Handler) {
      return new Handler(this)
    }
  }
}
