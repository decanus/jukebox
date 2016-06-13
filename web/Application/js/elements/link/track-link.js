/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'

export class TrackLink extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', () => {
      const player = app.getPlayer()

      app.modelRepository.getTrack(this.trackId)
        .then((track) => {
          if (this.append && player.getQueueSize() > 0) {
            player.appendTrack(track)
            return
          }

          player.prependTrack(track)
          player.setCurrent(0)
          player.play()
        })
    })
  }

  /**
   *
   * @returns {boolean}
   */
  get append () {
    return this.hasAttribute('push-to-queue')
  }

  /**
   *
   * @returns {number}
   */
  get trackId () {
    return Number.parseInt(this.getAttribute('track-id'))
  }
}
