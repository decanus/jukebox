/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from '../event/emitter'

class CustomElementWrapper {
  /**
   * @template T
   * @param {T} dom
   * @param {Observable} attributes
   */
  constructor(dom, attributes) {
    /**
     *
     * @type {T}
     */
    this.dom = dom

    /**
     *
     * @type {Observable}
     */
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

  /**
   *
   * @param {string} eventName
   * @param {{}} detail
   */
  emit(eventName, detail) {
    this.dom.dispatchEvent(new CustomEvent(eventName, detail))
  }
}

/**
 *
 * @template T
 * @param {T} Base
 * @param {(function(CustomElementWrapper<T>))} initFn
 * @param {Array<String>} exposedMethods
 * @returns {T}
 */
function makeCustomElement(Base, initFn, exposedMethods) {
  const Element = Object.create(Base.prototype)
  const emitter = new Emitter()

  Element.createdCallback = function () {
    initFn(new CustomElementWrapper(this, emitter.toObservable('attributeChanged')))
  }

  Element.attributeChangedCallback = function (name, oldValue, newValue) {
    // todo: this is not instance specific
    emitter.emit('attributeChanged', { name, oldValue, newValue })
  }
  

  return Element
}

/**
 *
 * @param {(function(CustomElementWrapper<HTMLElement>))} initializeFn
 * @param {Array<String>} exposedMethods
 * @returns {HTMLElement}
 */
export function CustomElement(initializeFn, exposedMethods) {
  return makeCustomElement(HTMLElement, initializeFn, exposedMethods)
}

/**
 *
 * @param {(function(CustomElementWrapper<HTMLAnchorElement>))} initializeFn
 * @param {Array<String>} exposedMethods
 * @returns {HTMLAnchorElement}
 */
export function CustomAnchorElement(initializeFn, exposedMethods) {
  return makeCustomElement(HTMLAnchorElement, initializeFn, exposedMethods)
}
