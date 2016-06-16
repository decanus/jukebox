/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../../views/resolve'
import { renderTemplate } from '../../render-template'

import { app } from '../../app'
import { Route } from '../../app/route'
import { sendException } from '../../app/analytics'
import { AppView } from '../../app/elements'

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

export class AppMount extends HTMLElement {

  createdCallback () {
    app.getRoute().forEach(async (route) => {
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
        // todo: change this

        sendException(error)

        if (app.getCurrentRoute().path === '/error') {
          return
        }

        app.setRoute(new Route('/error'), { silent: true })
      }
    })
  }
}
