/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class SearchField extends HTMLInputElement {
  createdCallback () {
    this.addEventListener('keyup', (e) => {
      if (e.keyCode !== 13) {
        return
      }

      const route = app.getCurrentRoute()
      const parts = route.split('/')
      let replace = (parts[1] === 'search')

      app.setRoute(`/search/${encodeURIComponent(this.value)}`, { replace })
    })
  }
}
