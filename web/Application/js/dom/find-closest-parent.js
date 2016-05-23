/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { matches } from './matches'

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

  if (matches(parent, selector)) {
    return parent
  }

  return findClosestParent(parent, selector)
}
