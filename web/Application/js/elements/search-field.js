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
      
      app.setRoute(`/search/${encodeURIComponent(this.value)}`)
    })
  }
}
