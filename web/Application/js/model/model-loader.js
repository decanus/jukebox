/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Track } from '../track/track'
import { YoutubeTrack } from '../track/youtube-track'
import { Artist } from '../models/artist'

export class ModelLoader {
  /**
   *
   * @param {ModelStore} store
   */
  constructor (store) {
    this._store = store
  }

  /**
   *
   * @param {{ id: number, type: string }} model
   */
  load (model) {
    switch (model.type) {
      case 'artists':
        return this.loadArtist(model)
      case 'tracks':
        return this.loadTrack(model)
      default:
        throw new Error(`unable to load model with type ${model.type}`)
    }
  }

  /**
   *
   * @param {{ id: number, type: string }} data
   * @returns {Artist}
   */
  loadArtist (data) {
    const artist = new Artist(data)

    this._store.put(artist)

    return artist
  }

  /**
   *
   * @param {{ id: number, type: string }} data
   * @returns {Track}
   */
  loadTrack (data) {
    const artist = this.loadArtist(data[ 'artists' ][ 0 ])
    const youtubeTrack = new YoutubeTrack(data['youtube_id'], data['duration'])
    const track = new Track({ ...data, artist }, { youtubeTrack })

    this._store.put(track)
    
    return track
  }
}
