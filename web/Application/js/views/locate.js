/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { StaticView } from './static-view'
import { SearchView } from './search-view'
import { ArtistView } from './artist-view'
import { ArtistTracksView } from './artist-tracks-view'

/**
 * @typedef {{ fetch: (function(): Promise<Page>), handle: (function(Page) ) }} View
 */

const views = {
  'static': StaticView,
  'artist': ArtistView,
  'artist-tracks': ArtistTracksView,
  'search': SearchView
}

/**
 *
 * @param {string} name
 * @returns {View}
 */
export function locateView (name) {
  if (views.hasOwnProperty(name)) {
    return views[name]
  }

  throw new Error(`unable to resolve view with name ${name}`)
}
