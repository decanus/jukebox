/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {HTMLElement} element
 * @param {string} selector
 * @returns {Node} 
 */
export function findClosestParent (element, selector) {
  let parent = element.parentNode

  if (parent === null || parent === element.ownerDocument) {
    return null
  }

  if (parent.matches(selector)) {
    return parent
  }

  return findClosestParent(parent, selector)
}
