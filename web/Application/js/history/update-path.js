/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {string} path
 * @todo: allow passing in the window instance
 */
export function updatePath (path) {
  if (window.location.pathname === path) {
    return
  }

  window.history.pushState(null, '', path)
}
