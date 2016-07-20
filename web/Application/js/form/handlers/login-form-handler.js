/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { User } from '../../value/user'

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
    app.user = new User(user.email, user.username)
  }
}
