/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Route } from '../app/route'
import { SharedPort } from '../shared/shared-port'
import { StorageWrapper } from '../dom/storage'

export class SearchField extends HTMLInputElement {
  createdCallback () {
    const port = new SharedPort('queue', new StorageWrapper(window.localStorage))

    port.listen((query) => {
      this.value = query
    })
    
    this.addEventListener('input', () => {
      port.push(this.value)
    })
    
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
