/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Route } from '../value/route'

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

    app.getRouteObservable()
      .forEach((route) => this._updateValue(route))

    this._updateValue(app.route)
  }

  _updateValue (route) {
    if (route.pathParts[0] !== 'search') {
      return
    }

    const params = route.params

    if (params.has('q')) {
      this.value = route.params.get('q')
    }
  }
}
