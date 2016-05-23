/**
 * @param {Array<Array<string>>} params
 * @returns {string}
 */
export function buildQuery (params) {
  return params
    .map((pair) => pair.map(encodeURIComponent).join('='))
    .join('&')
}
