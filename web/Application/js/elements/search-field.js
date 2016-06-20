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
      .forEach((route) => {
        let value = ''

        if (route.pathParts[ 0 ] === 'search') {
          value = route.params.get('q') || ''
        }

        this.value = value
      })
  }
}
