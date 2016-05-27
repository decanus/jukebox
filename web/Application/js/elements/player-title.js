/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'
import { CustomElement } from '../dom/custom-element'

/**
 *
 * @param {Application} app
 */
export function createPlayerTitle(app) {
  return CustomElement(($) => {

    $.dom.classList.add('player-title')

    let $title = createElement($.document, 'div', '')
    $title.classList.add('track')

    let $artist = createElement($.document, 'div', '')
    $artist.classList.add('artist')

    app.getPlayer()
      .getTrack()
      .forEach((track) => {
        console.log(track)

        $title.innerText = track.title
        $artist.innerText = track.artist
      })

    $.append($title)
    $.append($artist)
    
  })
}
