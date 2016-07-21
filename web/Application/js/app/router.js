/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Route } from './../value/route'
import { Signal } from './../event/signal'
import { trackPageView } from './analytics'
import { updatePath } from './../dom/history'

export class Router {
  constructor () {
    /**
     *
     * @type {Route} route
     */
    this._route = new Route.fromLocation(window.location)

    /**
     *
     * @type {Signal<Route>}
     */
    this.onRouteChanged = new Signal()
  }

  /**
   *
   * @returns {Route}
   */
  get route () {
    return this._route
  }

  /**
   *
   * @param {Route} route
   */
  set route (route) {
    this.setRoute(route)
  }

  /**
   *
   * @param {Route} route
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

    trackPageView(route)
  }
}
