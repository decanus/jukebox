/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { player } from '../../player'
import { fetchTrack } from '../../track/fetch-track'

export class TrackLink extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', () => {
      let promise = Promise.resolve()

      if (!this.pushToQueue) {
        promise = player.removeAllTracks()
      }

      promise
        .then(() => fetchTrack(this.trackId))
        .then((track) => {
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
