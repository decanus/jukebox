/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'
import { player } from '../player'

export class PlayerTitle extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.classList.add('player-title')

    let $title = createElement(this.ownerDocument, 'div', '')
    $title.classList.add('track')

    let $artist = createElement(this.ownerDocument, 'div', '')
    $artist.classList.add('artist')

    player.getTrack().forEach((track) => {
      $title.innerText = track.title
      $artist.innerText = track.artist
    })
    
    this.appendChild($title)
    this.appendChild($artist)
  }
}
