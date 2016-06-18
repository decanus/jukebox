/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'

export class TrackLink extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', async () => {
      const player = app.player

      const [ track, result ] = await Promise.all([
        app.modelRepository.getTrack(this.trackId),
        app.modelRepository.get({ type: this.resultType, id: this.resultId })
      ])

      if (this.append) {
        player.queueTrack(track)
      } else {
        player.playTrack(track, result)
      }
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

  /**
   *
   * @returns {string}
   */
  get resultId () {
    return this.getAttribute('result-id')
  }

  /**
   *
   * @returns {string}
   */
  get resultType () {
    return this.getAttribute('result-type')
  }
}
