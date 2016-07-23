/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {HTMLElement} $element
 * @returns {boolean}
 */
export function isElementInViewport ($element) {
  var rect = $element.getBoundingClientRect()

  return (
    rect.bottom > 0 &&
    rect.right > 0 &&
    rect.left < $element.ownerDocument.defaultView.innerWidth &&
    rect.top < $element.ownerDocument.defaultView.innerHeight
  )
}
