/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { updatePath } from '../history/update-path'
import { resolveRoute } from '../routing/routes'
import { renderTemplate } from '../templates'

export class JukeboxApp extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.ownerDocument.defaultView.addEventListener('popstate', () => {
      this.route = this.ownerDocument.defaultView.location.pathname
    })

    this.route = this.ownerDocument.defaultView.location.pathname
  }

  /**
   *
   * @param {string} attr
   */
  attributeChangedCallback (attr) {
    if (attr === 'route') {
      this.resolve()
    }
  }

  /**
   *
   * @returns {Promise}
   */
  resolve () {
    updatePath(this.route)

    return resolveRoute(this.route)
      .then((page) => {
        this.ownerDocument.title = page.title
        
        this.innerHTML = ''
        
        return renderTemplate(page.template, this.ownerDocument, page.data)
      })
      .then((dom) => {
        this.appendChild(dom)
      })
  }

  /**
   *
   * @returns {string}
   */
  get route () {
    return this.getAttribute('route')
  }

  /**
   *
   * @param {string} route
   */
  set route (route) {
    this.setAttribute('route', route)
  }
}
