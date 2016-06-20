/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { createElement } from '../../dom/create-element'


export class PlayerQueueItem extends HTMLElement {

  async createdCallback () {
    const track = await app.modelRepository.getTrack(this.trackId)
    const $container = createElement(this.ownerDocument, 'div', '', { 'class': 'player-queue-item' })

    const $title = createElement(this.ownerDocument, 'div', track.title, { 'class': 'title' })
    const $artist = createElement(this.ownerDocument, 'div', track.artistsString, { 'class': 'artist' })

    $container.appendChild($title)
    $container.appendChild($artist)

    $container.addEventListener('click', () => {
      app.player.setTrack(this.type, track)
    })
    
    this.appendChild($container)
  }

  /**
   *
   * @returns {number}
   */
  get trackId () {
    return Number.parseInt(this.getAttribute('track-id'))
  }

  /**
   *
   * @returns {number}
   */
  get index () {
    return Number.parseInt(this.getAttribute('index'))
  }

  /**
   *
   * @returns {boolean}
   */
  get current () {
    return this.hasAttribute('current')
  }

  /**
   *
   * @returns {string}
   */
  get type () {
    return this.getAttribute('type')
  }
}
