/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../../views/resolve'
import { renderTemplate } from '../../template/render'

import { app } from '../../app'
import { sendException } from '../../app/analytics'
import { AppView } from '../../app/elements'
import { RenderingStatus } from '../../dom/rendering'

const router = app.router

export class AppMount extends HTMLElement {
  createdCallback () {
    this._handleRoute = this._handleRoute.bind(this)
  }

  attachedCallback () {
    this._handleRoute(router.route)

    RenderingStatus.afterNextRender(() => {
      router.onRouteChanged.addListener(this._handleRoute)
    })
  }
  
  detachedCallback () {
    router.onRouteChanged.removeListener(this._handleRoute)
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
