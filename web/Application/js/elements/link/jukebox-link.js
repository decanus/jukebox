/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { Route } from '../../value/route'

export class JukeboxLink extends HTMLAnchorElement {
  createdCallback () {
    this._onClick = this._onClick.bind(this)
  }

  attachedCallback () {
    this.addEventListener('click', this._onClick)
  }
  
  detachedCallback () {
    this.removeEventListener('click', this._onClick)
  }

  /**
   *
   * @param {MouseEvent} event
   * @private
   */
  _onClick (event) {
    if (event.ctrlKey || event.metaKey) {
      return true
    }

    event.preventDefault()
    app.setRoute(Route.fromLocation(this))
  }
}
