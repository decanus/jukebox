/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import errors from '../../data/labels/form-errors.json'
import { findView } from '../dom/find-view'

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

      findView(this).reloadView()
    })
  }

  /**
   *
   * @returns {FormError}
   */
  get _$error () {
    return this.querySelector('form-error')
  }
}
