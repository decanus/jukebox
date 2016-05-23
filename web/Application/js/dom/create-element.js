/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @type {Function}
 */
const getProperties = Object.getOwnPropertyNames

/**
 *
 * @param {Document} document
 * @param {string} tagName
 * @param {string} [innerText]
 * @param {{}} [attributes]
 *
 * @returns {Element}
 */
export function createElement (document, tagName, innerText = '', attributes = {}) {
  let $elem

  if (attributes[ 'is' ]) {
    $elem = document.createElement(tagName, attributes[ 'is' ])
  } else {
    $elem = document.createElement(tagName)
  }

  // some html elements throw when trying to insert text
  try {
    $elem.innerText = innerText
  } catch (_) {

  }

  getProperties(attributes).forEach((name) => {
    $elem.setAttribute(name, attributes[ name ])
  })

  return $elem
}
