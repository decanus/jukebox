/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Page } from './page'

/**
 *
 * @param {number} artistId
 * @returns {View}
 */
export function ArtistProfilesView (artistId) {
  return {
    /**
     *
     * @returns {Page}
     */
    async fetch () {
      const profiles = await app.modelRepository.getArtistProfiles(artistId)

      return new Page({ title: '', template: 'artist-profiles', data: profiles })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      return () => {}
    }
  }
}
