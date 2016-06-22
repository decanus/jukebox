/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Route } from '../app/route'

export class SearchField extends HTMLInputElement {
  createdCallback () {
    this.addEventListener('keyup', (e) => {
      if (e.keyCode !== 13) {
        return
      }

      let params = new Map()

      if (this.value !== '') {
        params.set('q', this.value)
      }

      app.setRoute(new Route('/search', params))
    })

    app.getRoute()
      .filter((route) => route.pathParts[0] === 'search')
      .forEach((route) => {
        const params = route.params
        
        if (params.has('q')) {
          this.value = route.params.get('q')
        }
      })
  }
}
