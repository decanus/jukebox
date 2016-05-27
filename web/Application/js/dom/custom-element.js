/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'

class ElementWrapper {
  /**
   *
   * @param {HTMLElement} dom
   * @param {Observable} attributes
   */
  constructor(dom, attributes) {
    this.dom = dom
    this.attributes = attributes

    Object.freeze(this)
  }
}

/**
 *
 * @param {Function} initializeFn
 * @returns {HTMLElement}
 */
export function CustomElement(initializeFn) {
  const Element = Object.create(HTMLElement.prototype)
  const emitter = new Emitter()

  Element.createdCallback = function () {
    initializeFn(new ElementWrapper(this, emitter.toObservable('attributeChanged')))
  }

  Element.attributeChangedCallback = function (name, oldValue, newValue) {
    emitter.emit('attributeChanged', { name, oldValue, newValue })
  }

  return Element
}
