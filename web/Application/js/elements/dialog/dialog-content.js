/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createPromise } from '../../dom/events/create-promise'
import { createObservable } from '../../dom/events/create-observable'

const listener = new WeakMap()

export class DialogContent extends HTMLElement {

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

    const onKeyUp = (event) => {
      if (event.key === 'Escape' || event.which === 27) {
        this.close()
      }
    }

    document.addEventListener('keyup', onKeyUp)
    listener.set(this, onKeyUp)
  }

  detachedCallback () {
    document.removeEventListener('keyup', listener.get(this))
    listener.delete(this)
  }

  close () {
    createObservable(this, 'animationend')
      .take(2)
      .awaitAll()
      .then(() => {
        this.classList.remove('__close')
        this.isOpen = false
      })
    
    this.classList.add('__close')
  }
  
  open () {
    this.isOpen = true

    createPromise(this, 'animationend')
      .then(() => {
        this.classList.remove('__open')
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
  }
}
