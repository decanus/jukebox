/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { Uri } from '../../library/value/uri'
import { RenderingStatus } from '../../library/dom/rendering'

const router = app.router

export class SearchForm extends HTMLFormElement {

  createdCallback () {
    this._onSubmit = this._onSubmit.bind(this)
  }

  attachedCallback () {
    RenderingStatus.afterNextRender(() => {
      this.addEventListener('submit', this._onSubmit)
    })
  }

  /**
   *
   * @param {Event} event
   * @private
   */
  _onSubmit (event) {
    event.preventDefault()

    const field = this.querySelector('[is="search-field"]')
    const currentRoute = router.route
    const params = new Map()

    if (field.value !== '') {
      params.set('q', field.value)
    }

    if (currentRoute.pathParts[ 0 ] === 'search' && currentRoute.params.has('type')) {
      params.set('type', currentRoute.params.get('type'))
    }

    router.route = new Uri('/search', params)
  }
}
