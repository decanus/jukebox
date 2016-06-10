/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../../dom/create-element'
import { app } from '../../app'

export class PlayerTitle extends HTMLElement {
  createdCallback() {
    this.classList.add('player-title')

    let $title = createElement(this.ownerDocument, 'div', '')
    $title.classList.add('track')

    let $artist = createElement(this.ownerDocument, 'div', '')
    $artist.classList.add('artist')

    app.getPlayer()
      .getTrack()
      .forEach((track) => {
        $title.innerText = track.title
        $artist.innerText = track.artistsString
      })

    this.appendChild($title)
    this.appendChild($artist)
  }
}
