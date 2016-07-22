/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { RenderingStatus } from '../../dom/rendering'
import { createFragmentFromString } from '../../dom/fragment'

const SIGNIN_BUTTONS = `
<a view-name="register" href="/register" is="dialog-view-link">
    Sign Up
</a>
&#160; / &#160;
<a view-name="login" href="/login" is="dialog-view-link">
    Log In
</a>
`

const DROPDOWN = `
<div class="dropdown">
  <ul class="nav">
    <li class="-border"></li>
    <li>
        <form action="/action/logout" method="post">
            <button class="content-link" type="submit">Sign Out</button>
        </form>
    </li>
  </ul>
</div>
`

export class UserMenu extends HTMLElement {

  createdCallback () {
    this._onUserChange = this._onUserChange.bind(this)
  }

  attachedCallback () {
    RenderingStatus.afterNextRender(() => {
      app.onUserChange.addListener(this._onUserChange)
      this.addEventListener('click', this._onClick)
    })
  }

  detachedCallback () {
    app.onUserChange.removeListener(this._onUserChange)
    this.removeListener('click', this._onClick)
  }

  _onClick () {
    if (!app.user) {
      return
    }

    this.classList.toggle('-open')
  }

  _onUserChange () {
    const user = app.user

    if (!user) {
      this.innerHTML = SIGNIN_BUTTONS
      return
    }
    
    this.innerHTML = ''

    const $username = document.createElement('div')

    $username.className = 'username content-link'
    $username.textContent = `@${user.username}`

    const $dropdown = createFragmentFromString(this.ownerDocument, DROPDOWN)

    this.appendChild($username)
    this.appendChild($dropdown)
  }
}
