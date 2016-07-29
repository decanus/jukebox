/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { User } from '../../value/user'
import { Events } from '../../dom/events'
import { Uri } from '../../library/value/uri'

export class LoginFormHandler {
  /**
   *
   * @param {AjaxForm} form
   */
  constructor (form) {
    /**
     *
     * @type {AjaxForm}
     * @private
     */
    this._form = form
  }

  /**
   *
   * @param {{ email: string, username: string }} user
   */
  handle ({ user }) {
    app.user = new User(user.username, user.email)

    Events.dispatchViewExit(this._form, new Uri('/'))
  }
}
