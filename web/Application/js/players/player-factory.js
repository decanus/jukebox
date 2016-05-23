/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { DeezerPlayer } from './deezer-player/deezer-player'
import { SoundcloudPlayer } from './soundcloud-player'
import { YoutubePlayer } from './youtube-player'

export class PlayerFactory {
  /**
   *
   * @param {{}} tokens
   */
  constructor (tokens) {
    this._tokens = tokens
    this._instances = new Map()
  }

  /**
   *
   * @param {string} key
   * @returns {DeezerPlayer|SoundcloudPlayer|YoutubePlayer}
   */
  createPlayer (key) {
    switch (key) {
      case 'deezer':
        return new DeezerPlayer(this._tokens.deezerApplicationId)
      case 'soundcloud':
        return new SoundcloudPlayer(this._tokens.soundCloudClientId)
      case 'youtube':
        return new YoutubePlayer()
    }

    throw new Error(`invalid player key ${key}`)
  }

  /**
   *
   * @param {string} key
   * @returns {DeezerPlayer}
   */
  getPlayer (key) {
    let instances = this._instances

    if (!instances.has(key)) {
      instances.set(key, this.createPlayer(key))
    }

    return instances.get(key)
  }
}
