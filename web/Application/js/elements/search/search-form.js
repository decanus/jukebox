/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { Route } from '../../value/route'

export class SearchForm extends HTMLFormElement {
  createdCallback () {
    this.addEventListener('submit', (event) => {
      //noinspection JSUnresolvedFunction
      event.preventDefault()

      const field = this.querySelector('[is="search-field"]')
      const currentRoute = app.route
      const params = new Map()

      if (field.value !== '') {
        params.set('q', field.value)
      }

      if (currentRoute.pathParts[ 0 ] === 'search' && currentRoute.params.has('type')) {
        params.set('type', currentRoute.params.get('type'))
      }

      app.setRoute(new Route('/search', params))
    })
  }
}
