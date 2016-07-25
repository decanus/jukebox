/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement as _createElement } from '../dom/create-element'

/**
 * @todo implement drag & drop
 */
export class ScrobbleBar extends HTMLElement {
  createdCallback() {
    this.init()
    this.initDom()
    this.updateDom()
  }

  init() {
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
     * @type {boolean}
     * @private
     */
    this._dragging = false
  }

  initDom() {
    const createElement = (...args) => _createElement(this.ownerDocument, ...args)

    this.$bar = createElement('div', '', {'class': 'scrobble-bar'})
    this.$inner = createElement('div', '', {'class': 'inner'})
    this.$handle = createElement('div', '', {'class': 'handle'})

    this.$bar.addEventListener('click', (event) => {
      const box = this.$bar.getBoundingClientRect()
      const position = event.clientX - box.left
      this._value = position / box.width * this._total

      this._emitCurrentValue()
      this.updateDom()
    })

    this.$bar.appendChild(this.$inner)
    this.$bar.appendChild(this.$handle)

    this.appendChild(this.$bar)
  }

  _emitCurrentValue() {
    this.dispatchEvent(new CustomEvent('change', {detail: {value: this._value}}))
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
  setTotal(total) {
    this._total = total
    this.updateDom()
  }

  /**
   *
   * @param {number} value
   */
  setValue(value) {
    this._value = value
    this.updateDom()
  }

  reset() {
    this._value = 0
    this._total = 0
    this.updateDom()
  }
}
