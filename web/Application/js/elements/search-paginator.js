/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

const state = new WeakMap()
const listener = new WeakMap()

/**
 *
 * @param {HTMLElement} $element
 * @returns {boolean}
 */
function isElementInViewport($element) {
  var rect = $element.getBoundingClientRect()

  return (
    rect.bottom > 0 &&
    rect.right > 0 &&
    rect.left < $element.ownerDocument.defaultView.innerWidth &&
    rect.top < $element.ownerDocument.defaultView.innerHeight
  )
}

/**
 *
 * @param {SearchPaginator} $element
 */
function onScroll ($element) {
  if (!isElementInViewport($element) || state.get($element) === 'loading') {
    return
  }

  // fetch search from store
  const result = app.getModelStore()
    .get({ type: 'results', id: $element.resultId })
  
  

  state.set(this, 'loading')
}

export class SearchPaginator extends HTMLElement {

  createdCallback () {
    state.set(this, 'ready')
  }

  attachedCallback () {
    const _listener = () => onScroll(this)

    listener.set(this, _listener)
    window.addEventListener('scroll', _listener)
  }

  detachedCallback () {
    window.removeEventListener('scroll', listener.get(this))
  }

  /**
   *
   * @returns {string}
   */
  get resultId () {
    return this.getAttribute('result-id')
  }
}
