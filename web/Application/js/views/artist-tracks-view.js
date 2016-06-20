/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Page } from './page'
import { ViewRepository } from './view-repository'

/**
 *
 * @param {number} artistId
 * @returns {View}
 */
export function ArtistTracksView (artistId) {
  return {
    /**
     *
     * @returns {Page}
     */
    async fetch () {
      const tracks = await app.modelRepository.getArtistTracks(artistId)

      return new Page({ title: '', template: 'artist-tracks', data: { tracks, artistId } })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)
      
      page.data.tracks.results.forEach((track) => repository.hold(track))
      repository.hold(page.data.tracks)

      return () => repository.releaseAll()
    }
  }
}
