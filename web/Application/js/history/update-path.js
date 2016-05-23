/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {string} path
 */
export function updatePath (path) {
  if (window.location.pathname === path) {
    return
  }

  window.history.pushState(null, '', path)
}
