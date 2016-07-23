/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @type {WeakMap<FetchContent,string>}
 */
const internalState = new WeakMap()

/**
 *
 * @type {Function}
 */
const voidFn = () => {
}

/**
 *
 * @param {FetchContent} $
 * @param {string} value
 */
function setState ($, value) {
  internalState.set($, value)
  $.setAttribute('state', value)
}

/**
 *
 * @param {Response} response
 */
function rejectHttpErrors (response) {
  if (response.status < 200 || response.status >= 400) {
    return Promise.reject(new Error('failed to fetch'))
  }

  return response
}

/**
 *
 * @param {Response} response
 * @returns {Promise<string>}
 */
function getResponseText (response) {
  return response.text()
}

/**
 * This element has the following states:
 *
 * - initial
 * - pending
 * - fetched
 * - failed
 */
export class FetchContent extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    setState(this, 'initial')

    if (!this.href) {
      return
    }

    this.fetch().catch(voidFn)
  }

  /**
   *
   * @param {string} attr
   * @param {string} oldVal
   * @param {string} newVal
   */
  attributeChangedCallback (attr, oldVal, newVal) {
    if (attr === 'href') {
      this.href = newVal
    }
  }

  /**
   *
   * @returns {Promise}
   */
  fetch () {
    let state = this.state

    if (state === 'fetched') {
      return Promise.reject(new Error('already fetched'))
    }

    setState(this, 'pending')

    return this.ownerDocument.defaultView.fetch(this.href, {mode: 'same-origin'})
      .then(rejectHttpErrors)
      .then(getResponseText)
      .then((html) => {
        this.innerHTML = html
        this.dispatchEvent(new CustomEvent('fetch'))

        setState(this, 'fetched')
      })
      .catch((error) => {
        setState(this, 'failed')

        this.dispatchEvent(new CustomEvent('fail', {
          detail: error
        }))

        return Promise.reject(error)
      })
  }

  /**
   *
   * @returns {string}
   */
  get state () {
    return internalState.get(this)
  }

  /**
   *
   * @returns {string}
   */
  get href () {
    return this.getAttribute('href')
  }

  /**
   *
   * @param {string} value
   */
  set href (value) {
    if (value === this.href) {
      return
    }

    this.setAttribute('href', value)
    // reset state
    setState(this, 'initial')
    // fetch
    this.fetch().catch(voidFn)
  }
}
