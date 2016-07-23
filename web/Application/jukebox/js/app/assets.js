/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

//noinspection JSUnresolvedVariable
/**
 * @type {string|undefined}
 */
const assetVersion = window.__$assetVersion

/**
 * 
 * @param {string} path
 * @returns {string}
 */
export function getAssetPath (path) {
  if (assetVersion === undefined) {
    return path
  }

  const parts = path.split('.')
  const extension = parts.pop()
  const name = parts.join('.')
  
  return `${name}-${assetVersion}.${extension}`
}
