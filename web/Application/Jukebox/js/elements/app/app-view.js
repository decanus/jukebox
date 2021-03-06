/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { locateView } from '../../views/locate'
import { renderTemplate } from '../../library/template/render'
import { app } from  '../../app'

/**
 *
 * @param $element
 * @param {Page} page
 */
function render ($element, page) {
  const $html = renderTemplate(page.template, $element.ownerDocument, page.data)

  $element.innerHTML = ''
  $element.appendChild($html)

  if ($element.parentNode && $element.root) {
    $element.ownerDocument.title = page.title
  }
}

const cleanup = new WeakMap()

export class AppView extends HTMLElement {

  createdCallback () {
    this.innerHTML = '<div class="loading-animation -center"></div>'

    this._root = false
    this._name = this.getAttribute('name')

    try {
      this._data = JSON.parse(this.getAttribute('data'))
    } catch (ignored) {
      
    }
  }

  async attachedCallback () {
    try {
      const View = locateView(this.name)
      const view = View(this.data)

      const page = await view.fetch()

      // the user might have already navigated away at this point,
      // so let's check if we're still attached to the dom
      if (!this.parentNode) {
        return
      }

      cleanup.set(this, view.handle(page))

      render(this, page)

    } catch (error) {
      app.analytics.sendException(error)

      if (this.root) {
        this.innerHTML = ''
        this.appendChild(renderTemplate('error', this.ownerDocument))
      } else {
        this.innerHTML = '<strong>There was an error loading this page.</strong>'
      }
    }
  }

  detachedCallback () {
    if (cleanup.has(this)) {
      // call the view's cleanup function
      cleanup.get(this)()
    }
  }

  reloadView () {
    this.detachedCallback()

    this.innerHTML = '<div class="loading-animation -center"></div>'
    
    return this.attachedCallback()
  }

  /**
   *
   * @returns {string}
   */
  get name () {
    return this._name
  }

  /**
   *
   * @param {string} value
   */
  set name (value) {
    this._name = value
  }

  /**
   *
   * @returns {{}}
   */
  get data () {
    return this._data
  }

  /**
   *
   * @param {{}} value
   */
  set data (value) {
    this._data = value
  }

  /**
   *
   * @returns {boolean}
   */
  get rendered () {
    return this.hasAttribute('rendered')
  }

  /**
   *
   * @returns {boolean}
   */
  get root () {
    return this._root
  }

  /**
   *
   * @param {boolean} value
   */
  set root (value) {
    this._root = value
  }
}
