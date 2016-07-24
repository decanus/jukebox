/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Uri } from './../library/value/uri'
import { Signal } from './../event/signal'
import { updatePath } from '../library/dom/history'

export class Router {
  /**
   * 
   * @param {Analytics} analytics
   */
  constructor (analytics) {
    /**
     * 
     * @type {Analytics}
     * @private
     */
    this._analytics = analytics
    
    /**
     *
     * @type {Uri} route
     */
    this._route = new Uri.fromLocation(window.location)

    /**
     *
     * @type {Signal<Uri>}
     */
    this.onRouteChanged = new Signal()
  }

  /**
   *
   * @returns {Uri}
   */
  get route () {
    return this._route
  }

  /**
   *
   * @param {Uri} route
   */
  set route (route) {
    this.setRoute(route)
  }

  /**
   *
   * @param {Uri} route
   * @param {boolean} replace
   * @param {boolean} silent
   */
  setRoute (route, { replace = false, silent = false } = {}) {
    if (route.isSameValue(this._route)) {
      return
    }

    this._route = route
    this.onRouteChanged.dispatch(route)

    if (!silent) {
      updatePath(route, replace)
    }

    this._analytics.trackPageView(route)
  }

  registerPopstateListener () {
    window.addEventListener('popstate', () => {
      this.setRoute(Uri.fromLocation(window.location))
    })
  }
}
