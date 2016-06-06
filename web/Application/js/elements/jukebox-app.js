/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveRoute } from '../routing/routes'
import { renderTemplate } from '../templates'

import { app } from '../app'

/**
 *
 * @param $element
 * @param {string} route
 * @returns {Promise}
 */
function render($element, route) {
  return resolveRoute(route)
    .then((page) => {
      $element.ownerDocument.title = page.title
      $element.innerHTML = ''
      
      return renderTemplate(page.template, $element.ownerDocument, page.data)
    })
    .then((dom) => {
      $element.appendChild(dom)
    })
}

export class JukeboxApp extends HTMLElement {
  createdCallback() {
    app.getRoute()
      .forEach((route) => render(this, route))
  }
}
