/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolveRoute } from '../routing/routes'
import { renderTemplate } from '../templates'
import { CustomElement } from '../dom/custom-element'

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

/**
 *
 * @param {Application} app
 * @returns {HTMLElement}
 */
export function createJukeboxApp(app) {
  return CustomElement(($) => {
    app.getRoute().forEach((route) => render($.dom, route))
    
    $.attributes.forEach((attr) => console.log(attr.name, attr.newValue))
  })
}
