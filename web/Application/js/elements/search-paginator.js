/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchSearch } from '../apr/apr'

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
  if (!isElementInViewport($element) || state.get($element) === 'loading' || $element.hidden) {
    return
  }
  
  // fetch search from store
  const result = app.getModelStore()
    .get({ type: 'results', id: $element.resultId })
  
  const pagination = result.pagination

  if (pagination.page >= pagination.pages) {
    $element.hidden = true
  }

  state.set($element, 'loading')

  fetchSearch(result.query, pagination.page + 1)
    .then((newResult) => {
      result.pagination = newResult.pagination

      newResult.results
        .map((item) => app.getModelLoader().load(item))
        .forEach((model) => {
          result.results.push(model)
          app.getModelStore().hold(model)
        })

      app.reloadCurrentRoute()
      state.set($element, 'ready')
    })
    // todo: catch error
}

export class SearchPaginator extends HTMLElement {

  createdCallback () {
    state.set(this, 'ready')
  }

  attachedCallback () {
    const _listener = () => onScroll(this)

    listener.set(this, _listener)
    // todo: this is extremly ugly, need a better way to find the scrolling container
    document.querySelector('main').addEventListener('scroll', _listener)
    onScroll(this)
  }

  detachedCallback () {
    // todo: this is extremly ugly, need a better way to find the scrolling container
    document.querySelector('main').removeEventListener('scroll', listener.get(this))
  }

  /**
   *
   * @returns {string}
   */
  get resultId () {
    return this.getAttribute('result-id')
  }

  /**
   *
   * @param {boolean} hidden
   */
  set hidden (hidden) {
    if (hidden) {
      this.setAttribute('hidden', 'hidden')
    } else {
      this.removeAttribute('hidden')
    }
  }

  /**
   *
   * @returns {boolean}
   */
  get hidden () {
    return this.hasAttribute('hidden')
  }
}
