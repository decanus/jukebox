/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement as _createElement } from '../dom/create-element'
import { Emitter } from '../event/emitter'

/**
 * @todo implement drag & drop
 */
export class ScrobbleBar {
  /**
   * 
   * @param {HTMLElement} $element
   */
  constructor($element) {
    /**
     * 
     * @type {Emitter}
     * @private
     */
    this._emitter = new Emitter()
    
    /**
     * 
     * @type {number}
     * @private
     */
    this._total = 0

    /**
     * 
     * @type {number}
     * @private
     */
    this._value = 0

    /**
     * 
     * @type {HTMLElement}
     */
    this.$element = $element
  }
  
  initDom() {
    const createElement = (...args) => _createElement(this.$element.ownerDocument, ...args)

    this.$bar = createElement('div', '', { 'class': 'scrobble-bar' })
    this.$inner = createElement('div', '', { 'class': 'inner' })
    this.$handle = createElement('div', '', { 'class': 'handle'})

    this.$bar.addEventListener('click', (event) => {
      const box = this.$bar.getBoundingClientRect()
      const position = event.clientX - box.left
      this._value = position / box.width * this._total
      
      this._emitter.emit('change', this._value)
      this.updateDom()
    })

    this.$bar.appendChild(this.$inner)
    this.$bar.appendChild(this.$handle)
    
    this.$element.appendChild(this.$bar)
  }
  
  updateDom() {
    const pos = (100 / this._total * this._value) + '%'

    this.$inner.style.width = pos
    this.$handle.style.left = pos
  }

  /**
   * 
   * @param {number} total
   */
  set total(total) {
    this._total = total
    this.updateDom()
  }

  /**
   * 
   * @param {number} value
   */
  set value(value) {
    this._value = value
    this.updateDom()
  }
}
