/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Route } from '../value/route'

export class SearchForm extends HTMLFormElement {
  createdCallback () {
    this.addEventListener('submit', (event) => {
      event.preventDefault()

      const field = this.querySelector('[is="search-field"]')
      const params = new Map()

      if (field.value !== '') {
        params.set('q', field.value)
      }

      app.setRoute(new Route('/search', params))
    })
  }
}
