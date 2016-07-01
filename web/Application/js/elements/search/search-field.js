/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'

export class SearchField extends HTMLInputElement {
  createdCallback () {
    app.getRouteObservable()
      .forEach((route) => this._updateValue(route))

    this._updateValue(app.route)
  }

  _updateValue (route) {
    if (route.pathParts[ 0 ] !== 'search') {
      return
    }

    const params = route.params

    if (params.has('q')) {
      this.value = route.params.get('q')
    }
  }
}
