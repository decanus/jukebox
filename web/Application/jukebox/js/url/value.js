/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {string} value
 * @returns {string}
 */
export function decodeValue(value) {
  if (value == null) {
    return value
  }

  return decodeURIComponent(value.replace("+", "%20"))
}

/**
 *
 * @param {string} value
 * @returns {string}
 */
export function encodeValue(value) {
  if (value == null) {
    return value
  }

  return encodeURIComponent(value).replace("%20", "+")
}
