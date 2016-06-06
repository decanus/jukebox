/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class SearchField extends HTMLInputElement {
  createdCallback () {
    this.addEventListener('input', () => {
      const route = app.getCurrentRoute()
      const parts = route.split('/')
      let replace = (parts[1] === 'search')
      
      console.log(route)
      
      app.setRoute(`/search/${encodeURIComponent(this.value)}`, { replace })
    })
  }
}
