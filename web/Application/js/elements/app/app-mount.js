/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../../views/resolve'
import { renderTemplate } from '../../template/render'

import { app } from '../../app'
import { sendException } from '../../app/analytics'
import { AppView } from '../../app/elements'
import { Events } from '../../dom/events'
import { RenderingStatus } from '../../dom/rendering'

export class AppMount extends HTMLElement {
  createdCallback () {
    this._onRoute = this._onRoute.bind(this)
    this._onViewExit = this._onViewExit.bind(this)
    
    this._onRoute(app.route)
  }

  attachedCallback () {
    RenderingStatus.afterNextRender(() => {
      app.getRouteObservable()
        .forEach((route) => this._onRoute(route))

      this.addEventListener(Events.VIEW_EXIT_EVENT, this._onViewExit)
    })
  }

  detachedCallback () {
    this.removeEventListener(Events.VIEW_EXIT_EVENT, this._onViewExit)
  }

  /**
   *
   * @param {Route} route
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
      sendException(error)

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
    const route = event.detail.redirectRoute

    if (route != null) {
      app.setRoute(route)
    }

    event.stopPropagation()
  }
}
