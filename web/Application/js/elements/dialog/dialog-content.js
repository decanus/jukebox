/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createPromise } from '../../dom/events/create-promise'
import { createObservable } from '../../dom/events/create-observable'
import { Detabinator } from '../../dom/detabinator'

export class DialogContent extends HTMLElement {

  createdCallback () {
    this._onKeyUp = this._onKeyUp.bind(this)

    /**
     * 
     * @type {Detabinator}
     * @private
     */
    this._detabinator = new Detabinator(this)
  }

  /**
   *
   * @param {KeyboardEvent} event
   * @private
   */
  _onKeyUp (event) {
    if (event.key === 'Escape' || event.which === 27) {
      this.close()
    }
  }

  attachedCallback () {
    const nodes = Array.from(this.childNodes)
    const content = this.ownerDocument.createElement('div')
    const backdrop = this.ownerDocument.createElement('div')

    content.className = '__content'
    backdrop.className = '__backdrop'

    nodes.forEach((node) => content.appendChild(node))

    this.appendChild(content)
    this.appendChild(backdrop)

    backdrop.addEventListener('click', () => this.close())

    document.addEventListener('keyup', this._onKeyUp)
  }

  detachedCallback () {
    document.removeEventListener('keyup', this._onKeyUp)
  }

  close () {
    createObservable(this, 'animationend')
      .take(2)
      .awaitAll()
      .then(() => {
        this.classList.remove('__close')
        this.isOpen = false
        this.dispatchEvent(new CustomEvent('close'))
      })

    this.classList.add('__close')
  }

  open () {
    this.isOpen = true
    this.style.willChange = 'transform'

    createPromise(this, 'animationend')
      .then(() => {
        this.classList.remove('__open')
        this.dispatchEvent(new CustomEvent('open'))
      })

    this.classList.add('__open')
  }

  /**
   *
   * @returns {boolean}
   */
  get isOpen () {
    return this.hasAttribute('open')
  }

  /**
   *
   * @param {boolean} value
   */
  set isOpen (value) {
    if (value) {
      this.setAttribute('open', '')
    } else {
      this.removeAttribute('open')
    }

    this._detabinator.inert = !value
  }
}
