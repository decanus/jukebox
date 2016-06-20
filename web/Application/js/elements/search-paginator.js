/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchSearch } from '../app/apr'
import { findView } from '../dom/find-view'

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
async function onScroll ($element) {
  if (!isElementInViewport($element) || state.get($element) === 'loading' || $element.hidden) {
    return
  }

  const repository = app.modelRepository
  const result = await repository.get({ id: $element.resultId, type: $element.resultType })

  const pagination = result.pagination

  if (pagination.page >= pagination.pages) {
    $element.hidden = true
    return
  }

  state.set($element, 'loading')

  const newResult = await fetchSearch(result.query, pagination.page + 1)
  const newResults = newResult.results.map((data) => repository.add(data))

  result.pagination = newResult.pagination
  result.results = result.results.concat(newResults)

  await findView($element).reloadView()

  state.set($element, 'ready')
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
   * @returns {string}
   */
  get resultType () {
    return this.getAttribute('result-type')
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
