/**
 *
 * Copyright 2016 Google Inc. All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Usage:
 * const detabinator = new Detabinator(element);
 * detabinator.inert = true;  // Sets all focusable children of element to tabindex=-1
 * detabinator.inert = false; // Restores all focusable children of element
 * Limitations: Doesn't support Shadow DOM v0 :P
 */

/**
 *
 * @type {string}
 */
const focusableElementsString = 'a[href], area[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex], [contenteditable]'

export class Detabinator {
  /**
   *
   * @param {HTMLElement} element
   */
  constructor (element) {
    if (!element) {
      throw new Error('Missing required argument. new Detabinator needs an element reference')
    }

    /**
     *
     * @type {HTMLElement}
     * @private
     */
    this._element = element

    /**
     *
     * @type {boolean}
     * @private
     */
    this._inert = false
  }

  /**
   *
   * @returns {boolean|}
   */
  get inert () {
    return this._inert
  }

  /**
   *
   * @param {boolean} isInert
   */
  set inert (isInert) {
    if (this._inert === isInert) {
      return
    }

    this._inert = isInert

    const focusableElements = Array.from(
      this._element.querySelectorAll(focusableElementsString)
    )

    focusableElements.forEach((child) => {
      if (isInert) {
        // If the child has an explict tabindex save it
        if (child.hasAttribute('tabindex')) {
          child.__savedTabIndex = child.tabIndex
        }
        // Set ALL focusable children to tabindex -1
        child.setAttribute('tabindex', -1)
      } else {
        // If the child has a saved tabindex, restore it
        // Because the value could be 0, explicitly check that it's not false
        if (child.__savedTabIndex === 0 || child.__savedTabIndex) {
          return child.setAttribute('tabindex', child.__savedTabIndex)
        } else {
          // Remove tabindex from ANY REMAINING children
          child.removeAttribute('tabindex')
        }
      }
    });
  }
}
