/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../../views/resolve'
import { renderTemplate } from '../../library/template/render'

import { app } from '../../app'
import { AppView } from '../../app/elements'
import { Events } from '../../dom/events'
import { RenderingStatus } from '../../library/dom/rendering'

const router = app.router

export class AppMount extends HTMLElement {
  createdCallback () {
    this._onRoute = this._onRoute.bind(this)
    this._onViewExit = this._onViewExit.bind(this)
  }

  attachedCallback () {
    this._onRoute(router.route)

    RenderingStatus.afterNextRender(() => {
      router.onRouteChanged.addListener(this._onRoute)
      this.addEventListener(Events.VIEW_EXIT_EVENT, this._onViewExit)
    })
  }

  detachedCallback () {
    router.onRouteChanged.removeListener(this._onRoute)
    this.removeEventListener(Events.VIEW_EXIT_EVENT, this._onViewExit)
  }

  /**
   *
   * @param {Uri} route
   * @private
   */
  async _onRoute (route) {
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
      app.analytics.sendException(error)

      this.innerHTML = ''
      this.appendChild(renderTemplate('error', this.ownerDocument))
    }
  }

  /**
   *
   * @param {Event} event
   * @private
   */
  _onViewExit (event) {
    //noinspection JSUnresolvedVariable
    const route = event.detail.redirectRoute

    if (route != null) {
      router.route = route
    }

    event.stopPropagation()
  }
}
