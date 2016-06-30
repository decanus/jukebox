/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchResults } from '../app/apr'
import { findView } from '../dom/find-view'
import { ResultId } from '../value/result-id'
import { isElementInViewport } from '../dom/viewport'

const state = new WeakMap()
const listener = new WeakMap()

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

  /** @type {ResultId} */
  const id = result.id

  const newResult = await fetchResults($element.resultType, id.query, pagination.page + 1, id.includes)
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
    app.$main.addEventListener('scroll', _listener)
  }

  detachedCallback () {
    app.$main.removeEventListener('scroll', listener.get(this))
  }

  /**
   *
   * @returns {ResultId}
   */
  get resultId () {
    return ResultId.fromString(this.getAttribute('result-id'))
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
