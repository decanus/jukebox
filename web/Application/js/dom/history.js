/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Route } from '../app/route'

/**
 *
 * @param {Route} route
 * @param {boolean} replace
 */
export function updatePath (route, replace = false) {
  const currentState = Route.fromLocation(window.location)
  
  if (currentState.isSameValue(route)) {
    return
  }

  if (replace) {
    window.history.replaceState(null, '', route.toString())
  } else {
    window.history.pushState(null, '', route.toString())
  }
}
