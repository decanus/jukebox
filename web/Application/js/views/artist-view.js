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
     * @returns {Promise<Page>}
     */
    fetch () {
      return app.modelRepository
        .getArtist(artistId)
        .then((artist) => {
          return new Page({ title: `Jukebox Ninja - ${artist.name}`, template: 'artist', data: artist })
        })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)

      repository.hold(page.data)

      return () => repository.releaseAll()
    }
  }
}
