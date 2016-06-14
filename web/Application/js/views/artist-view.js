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
export function ArtistView (artistId) {
  return {
    /**
     *
     * @returns {Page}
     */
    async fetch () {
      const repository = app.modelRepository

      let [ artist, tracks ] = await Promise.all([
        repository.getArtist(artistId),
        fetchArtistTracks(artistId)
      ])

      tracks = tracks.map((data) => repository.add(data))

      return new Page({ title: `Jukebox Ninja - ${artist.name}`, template: 'artist', data: { artist, tracks } })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)
      const data = page.data

      repository.hold(data.artist)

      data.tracks.forEach((track) => repository.hold(track))

      return () => repository.releaseAll()
    }
  }
}
