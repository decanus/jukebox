/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { ResultId } from '../../value/result-id'

export class PlayTrackLink extends HTMLElement {
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

      player.playTrack(track, result)
    })
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
   * @returns {ResultId}
   */
  get resultId () {
    return ResultId.fromString(this.getAttribute('result-id'))
  }

  /**
   *
   * @returns {string}
   */
  get resultType () {
    return this.getAttribute('result-type')
  }
}
