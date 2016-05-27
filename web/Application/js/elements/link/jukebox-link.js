/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { CustomAnchorElement } from '../../dom/custom-element'

/**
 *
 * @param {Application} app
 * @returns {HTMLAnchorElement}
 */
export function createJukeboxLink(app) {
  return CustomAnchorElement(($) => {
    $.dom.addEventListener('click', (event) => {
      if (event.ctrlKey || event.metaKey) {
        return
      }

      event.preventDefault()
      app.setRoute($.dom.pathname)
    })
  })
}
