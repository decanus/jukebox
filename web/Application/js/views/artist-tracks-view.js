/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchArtistTracks } from '../app/apr'
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
      const repository = app.modelRepository
      let tracks = await fetchArtistTracks(artistId)

      tracks = tracks.map((data) => repository.add(data))

      return new Page({ title: '', template: 'artist-tracks', data: { tracks } })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)

      page.data.tracks.forEach((track) => repository.hold(track))

      return () => repository.releaseAll()
    }
  }
}
