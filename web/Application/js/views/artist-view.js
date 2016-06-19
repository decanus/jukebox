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
export function ArtistView (artistId) {
  return {
    /**
     *
     * @returns {Page}
     */
    async fetch () {
      const repository = app.modelRepository
      const artist = await repository.getArtist(artistId)

      return new Page({ title: `Jukebox Ninja - ${artist.name}`, template: 'artist', data: { artist } })
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

      return () => repository.releaseAll()
    }
  }
}
