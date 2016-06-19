/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {string} url
 * @returns {{ path: string, host: string }}
 */
export function parseUrl (url) {
  const anchor = document.createElement('a')
  anchor.href = url

  return {
    path: anchor.pathname,
    host: anchor.hostname
  }
}
