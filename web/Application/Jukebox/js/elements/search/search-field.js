/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { RenderingStatus } from '../../library/dom/rendering'

const router = app.router

export class SearchField extends HTMLInputElement {
  
  createdCallback () {
    this._updateValue = this._updateValue.bind(this)
  }
  
  attachedCallback () {
    this._updateValue(router.route)
    
    RenderingStatus.afterNextRender(() => {
      router.onRouteChanged.addListener(this._updateValue)
    })
  }
  
  detachedCallback () {
    router.onRouteChanged.removeListener(this._updateValue)
  }

  /**
   * 
   * @param {Route} route
   * @private
   */
  _updateValue (route) {
    if (route.pathParts[ 0 ] !== 'search') {
      return
    }

    const params = route.params

    if (params.has('q')) {
      //noinspection JSUnresolvedVariable
      this.value = route.params.get('q')
    }
  }
}
