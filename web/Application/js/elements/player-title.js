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

    let $title = createElement(this.ownerDocument, 'div')

    player.getTrack().forEach((track) => {
      $title.innerText = track.title
    })
  }
}
