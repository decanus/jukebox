/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement as _createElement } from '../dom/create-element'
import { createObservable, createMultiObservable } from '../dom/events/create-observable'
import { Observable } from '../observable'

const DRAG_EVENT = {
  START: 0,
  DRAGGING: 1,
  END: 2
}

/**
 *
 * @param {HTMLElement} $el
 * @param {HTMLElement} $container
 */
function draggable($el, $container) {
  let dragging = false

  const mouseDowns = createObservable($el, 'mousedown')
    .map(() => ({ type: DRAG_EVENT.START }))

  const _mouseUps = createObservable(document, 'mouseup')
    .map(() => ({ type: DRAG_EVENT.END }))

  const mouseUps = _mouseUps.filter(() => dragging)
  
  const mouseLeaves = createObservable(document, 'mouseleave')
    .map(() => ({ type: DRAG_EVENT.END }))
    .filter(() => dragging)

  mouseLeaves.forEach(() => console.log('mouse leave'))

  const startEnds = Observable.merge(mouseDowns, mouseUps, mouseLeaves)
    .distinct()

  _mouseUps.forEach(() => {
    dragging = false
  })

  startEnds.forEach((event) => {
    dragging = (event.type === DRAG_EVENT.START)
  })

  const mouseMoves = createObservable(document, 'mousemove')
    .filter(() => dragging)
    .map((event) => {
      const box = $container.getBoundingClientRect()
      let position = event.clientX - box.left

      position = Math.max(position, 0)
      position = Math.min(position, box.width)

      return { type: DRAG_EVENT.DRAGGING, value: position }
    })

  return Observable.merge(startEnds, mouseMoves)
}

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

    /*let dragEvents = draggable(this.$handle, this.$bar)

    dragEvents
      .filter((event) => event.type === DRAG_EVENT.START)
      .forEach(() => {
        this._dragging = true
        this.updateDom()
        console.log('start')
      })

    dragEvents
      .filter((event) => event.type === DRAG_EVENT.END)
      .forEach(() => {
        this._dragging = false
        this._emitCurrentValue()
        this.updateDom()
        console.log('end')
      })

    dragEvents
      .filter((event) => event.type === DRAG_EVENT.DRAGGING)
      .forEach((event) => {
        const box = this.$bar.getBoundingClientRect()
        this._value = event.value / box.width * this._total
        this.updateDom()
      })*/

    this.appendChild(this.$bar)
  }

  _emitCurrentValue() {
    this.dispatchEvent(new CustomEvent('change', {detail: {value: this._value}}))
  }

  updateDom() {
    const pos = (100 / this._total * this._value) + '%'

    this.$inner.style.width = pos
    this.$handle.style.left = pos

    if (this._dragging) {
      this.$bar.classList.add('-dragging')
    } else {
      this.$bar.classList.remove('-dragging')
    }
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
    if (this._dragging) return

    this._value = value
    this.updateDom()
  }

  reset() {
    this._value = 0
    this._total = 0
    this._dragging = false
    this.updateDom()
  }
}
