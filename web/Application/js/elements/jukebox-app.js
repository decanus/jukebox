/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../views/resolve'
import { renderTemplate } from '../render-template'

import { app } from '../app'
import { Route } from '../app/route'
import { sendException } from '../app/analytics'

/**
 *
 * @param $element
 * @param {Page} page
 * @returns {Promise}
 */
function render ($element, page) {
  $element.ownerDocument.title = page.title
  $element.innerHTML = ''

  const $html = renderTemplate(page.template, $element.ownerDocument, page.data)
  $element.appendChild($html)
}

//
// yep @brendaneich you fucked up
//
const cleanup = new WeakMap()
const activeView = new WeakMap()

export class JukeboxApp extends HTMLElement {

  createdCallback () {
    app.getRoute().forEach(async (route) => {
      const view = await resolveView(route)

      activeView.set(this, view)
      this.innerHTML = '<div class="loading-animation -center"></div>'

      const page = await view.fetch()

      try {
        const active = activeView.get(this)

        if (active !== view && active !== undefined) {
          return
        }

        if (cleanup.has(this)) {
          // call cleanup function from previous view
          cleanup.get(this)()
        }

        cleanup.set(this, view.handle(page))
        render(this, page)
      } catch (error) {
        if (app.getCurrentRoute().path === '/error') {
          return
        }

        app.setRoute(new Route('/error'), { silent: true })

        sendException(error)
      }
    })
  }
}
