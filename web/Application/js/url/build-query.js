/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @param {Array<Array<string>>} params
 * @returns {string}
 */
export function buildQuery (params) {
  return params
    .map((pair) => pair.map(encodeURIComponent).join('='))
    .join('&')
}
