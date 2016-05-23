/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { updatePath } from '../history/update-path'
import { resolveRoute } from '../routes'
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
      .then((resolved) => {
        this.ownerDocument.title = resolved.title

        this.innerHTML = ''
        this.appendChild(renderTemplate(resolved.template, this.ownerDocument, resolved.data))
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
