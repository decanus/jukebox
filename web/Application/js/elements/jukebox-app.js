/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveView } from '../views/resolve'
import { renderTemplate } from '../templates'

import { app } from '../app'

const store = app.getModelStore()

/**
 *
 * @param $element
 * @param {Page} page
 * @returns {Promise}
 */
function render($element, page) {
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
  
  createdCallback() {
    app.getRoute().forEach((route) => {
      const view = resolveView(route)

      activeView.set(this, view)

      view.fetch()
        .then((page) => {
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
        })
    })
  }
}
