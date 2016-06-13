/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchSearch } from '../app/apr'

const state = new WeakMap()
const listener = new WeakMap()

/**
 *
 * @param {HTMLElement} $element
 * @returns {boolean}
 */
function isElementInViewport ($element) {
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

  const repository = app.modelRepository
  const result = repository.getResults($element.resultId)

  const newResult = result.then((result) => {
    const pagination = result.pagination

    if (pagination.page >= pagination.pages) {
      $element.hidden = true
    }

    state.set($element, 'loading')

    return fetchSearch(result.query, pagination.page + 1)
  })

  Promise.all([result, newResult])
    .then((values) => {
      const result = values[0]
      const newResult = values[1]
      const newResults = newResult.results.map((data) => repository.add(data))

      result.pagination = newResult.pagination
      result.results = result.results.concat(newResults)

      app.reloadCurrentRoute()

      state.set($element, 'ready')
    })
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
