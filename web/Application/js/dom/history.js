/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Route } from '../app/route'

/**
 *
 * @param {Route} route
 * @todo: allow passing in the window instance
 */
export function updatePath (route) {
  const currentState = Route.fromLocation(window.location)
  
  if (currentState.isSameValue(route)) {
    return
  }

  window.history.pushState(null, '', route.toString())
}

/**
 *
 * @param {string} path
 * @todo: allow passing in the window instance
 */
export function replacePath (path) {
  if (window.location.pathname === path) {
    return
  }

  window.history.replaceState(null, '', path)
}
