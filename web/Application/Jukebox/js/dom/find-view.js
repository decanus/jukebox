/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { findClosestParent } from '../library/dom/find-closest-parent'

/**
 *
 * @param {Element} element
 * @returns {AppView}
 */
export function findView (element) {
  //noinspection JSValidateTypes
  return findClosestParent(element, 'app-view')
}
