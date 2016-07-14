/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../../views/resolve'
import { renderTemplate } from '../../template/render'

import { app } from '../../app'
import { sendException } from '../../app/analytics'
import { AppView } from '../../app/elements'

export class AppMount extends HTMLElement {

  createdCallback () {
    app.getRouteObservable()
      .forEach((route) => this._handleRoute(route))

    this._handleRoute(app.route)
  }

  /**
   * 
   * @param {Route} route
   * @private
   */
  async _handleRoute (route) {
    try {

      this.innerHTML = '<div class="loading-animation -center"></div>'

      const resolved = await resolveView(route)
      const view = new AppView()

      view.data = resolved.data
      view.name = resolved.name
      view.root = true

      this.innerHTML = ''
      this.appendChild(view)

    } catch (error) {
      sendException(error)

      this.innerHTML = ''
      this.appendChild(renderTemplate('error', this.ownerDocument))
    }
  }
}
