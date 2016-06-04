/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { createElement } from '../dom/create-element'

const player = app.getPlayer()

export class PlayerQueueItem extends HTMLElement {
  /**
   *
   * @param {Track} track
   * @param {number} index
   */
  init (track, index) {
    const $container = createElement(this.ownerDocument, 'div', '', { 'class': 'player-queue-item' })

    const $title = createElement(this.ownerDocument, 'div', track.title, { 'class': 'title' })
    const $artist = createElement(this.ownerDocument, 'div', track.artist, { 'class': 'artist' })

    $container.appendChild($title)
    $container.appendChild($artist)

    $container.addEventListener('click', () => {
      player.setCurrent(index)
    })

    if (player.getCurrent() === index) {
      $container.classList.add('-active')
    }

    this.appendChild($container)
  }
}
