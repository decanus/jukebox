/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'

/**
 *
 * @param {Application} app
 */
export function createPlayerTitle(app) {
  const PlayerTitle = Object.create(HTMLElement.prototype)

  PlayerTitle.createdCallback = function () {
    this.classList.add('player-title')

    let $title = createElement(this.ownerDocument, 'div', '')
    $title.classList.add('track')

    let $artist = createElement(this.ownerDocument, 'div', '')
    $artist.classList.add('artist')

    app.getPlayer()
      .getTrack()
      .forEach((track) => {
        console.log(track)
        
        $title.innerText = track.title
        $artist.innerText = track.artist
      })

    this.appendChild($title)
    this.appendChild($artist)
  }

  return PlayerTitle
}
