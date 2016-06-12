/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Track } from '../models/track'
import { TrackArtist } from '../models/track-artist'
import { YoutubeTrack } from '../models/youtube-track'
import { Artist } from '../models/artist'
import { Result } from '../models/result'

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
      case 'results':
        return this.loadResult(model)
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
    let youtubeTrack

    data['isExplicit'] = data['is_explicit']

    data.sources.forEach((source) => {
      if (source.source === 'youtube') {
        youtubeTrack = new YoutubeTrack(source[ 'source_data' ], source[ 'duration' ])
      }
    })

    const artists = data.artists
      .sort((a, b) => {
        if (a.role === b.role) {
          return 0
        }

        if (a.role === 'featured' && b.role === 'main') {
          return 1
        }
        
        return -1
      })
      .map((artist, i) => {
        return new TrackArtist(artist.role, this.loadArtist(artist), i)
      })

    const track = new Track({ ...data, artists }, { youtubeTrack })

    this._store.put(track)

    return track
  }

  /**
   *
   * @param {{ id: string, results: Array, pagination: {} }} data
   */
  loadResult (data) {
    const results = data.results.map((model) => this.load(model))
    const result = new Result({ id: data.id, results, pagination: data.pagination })

    this._store.put(result)

    return result
  }
}
