/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'

class ElementWrapper {
  /**
   *
   * @param {T} dom
   * @template T
   * @param {Observable} attributes
   */
  constructor(dom, attributes) {
    this.dom = dom
    this.attributes = attributes

    Object.freeze(this)
  }

  /**
   *
   * @returns {Document}
   */
  get document() {
    return this.dom.ownerDocument
  }

  /**
   *
   * @template T
   * @param {T} node
   * @returns {T}
   */
  append(node) {
    return this.dom.appendChild(node)
  }
}

/**
 * @callback initializeFn
 * @param {ElementWrapper} $
 */

/**
 *
 * @template T
 * @param {T} Base
 * @param {(function(ElementWrapper<T>))} initializeFn
 * @returns {T}
 */
function makeCustomElement(Base, initializeFn) {
  const Element = Object.create(Base.prototype)
  const emitter = new Emitter()

  Element.createdCallback = function () {
    initializeFn(new ElementWrapper(this, emitter.toObservable('attributeChanged')))
  }

  Element.attributeChangedCallback = function (name, oldValue, newValue) {
    emitter.emit('attributeChanged', { name, oldValue, newValue })
  }

  return Element
}

/**
 *
 * @param {(function(ElementWrapper<HTMLElement>))} initializeFn
 * @returns {HTMLElement}
 */
export function CustomElement(initializeFn) {
  return makeCustomElement(HTMLElement, initializeFn)
}

/**
 * 
 * @param {(function(ElementWrapper<HTMLAnchorElement>))} initializeFn
 * @returns {HTMLAnchorElement}
 */
export function CustomAnchorElement(initializeFn) {
  return makeCustomElement(HTMLAnchorElement, initializeFn)
}
