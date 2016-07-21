/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { RenderingStatus } from '../../dom/rendering'

const SIGNIN_BUTTONS = `
<a view-name="register" href="/register" is="dialog-view-link">
    Sign Up
</a>
&#160; / &#160;
<a view-name="login" href="/login" is="dialog-view-link">
    Log In
</a>
`

export class UserMenu extends HTMLElement {

  createdCallback () {
    this._onUserChange = this._onUserChange.bind(this)
  }

  attachedCallback () {
    RenderingStatus.afterNextRender(() => {
      app.onUserChange.addListener(this._onUserChange)
    })
  }

  detachedCallback () {
    app.onUserChange.removeListener(this._onUserChange)
  }

  _onUserChange () {
    const user = app.user

    if (!user) {
      this.innerHTML = SIGNIN_BUTTONS
      return
    }

    this.innerText = `Hi ${user.username}`
  }
}
