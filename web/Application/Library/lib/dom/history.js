/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Uri } from '../value/uri'

/**
 *
 * @param {Uri} uri
 * @param {boolean} replace
 */
export function updatePath (uri, replace = false) {
  const currentState = Uri.fromLocation(window.location)
  
  if (currentState.isSameValue(uri)) {
    return
  }

  if (replace) {
    window.history.replaceState(null, '', uri.toString())
  } else {
    window.history.pushState(null, '', uri.toString())
  }
}
