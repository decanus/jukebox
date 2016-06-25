/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { Route } from '../../value/route'

export class JukeboxLink extends HTMLAnchorElement {
  createdCallback() {
    this.addEventListener('click', (event) => {
      if (event.ctrlKey || event.metaKey) {
        return
      }

      event.preventDefault()
      app.setRoute(Route.fromLocation(this))
    })
  }
}
