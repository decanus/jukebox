/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlayerQueue } from './player-queue'

export class ResultsQueue {

  constructor () {
    /**
     *
     * @type {PlayerQueue}
     * @private
     */
    this._queue = new PlayerQueue()

    /**
     *
     * @type {Result}
     * @private
     */
    this._result = null
  }

  /**
   * 
   * @param {Result} result
   */
  setResult (result) {
    this._result = result

    result.results
      .filter((model) => model.type === 'tracks')
      .forEach((track) => {
        this._queue.appendTrack(track)
      })
  }
}
