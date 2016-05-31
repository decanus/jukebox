/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { fetchTrack } from '../../track/fetch-track'

export class TrackLink extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', () => {
      const player = app.getPlayer()
      let promise = Promise.resolve()

      if (!this.pushToQueue) {
        promise = player.removeAllTracks()
      }
      
      console.log('clicked')

      promise
        .then(() => fetchTrack(this.trackId))
        .then((track) => {
          console.log(track)
          player.addTrack(track)
          player.play()
        })
    })
  }

  /**
   *
   * @returns {boolean}
   */
  get pushToQueue () {
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
