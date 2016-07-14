/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { StaticView } from './static-view'
import { SearchView } from './search-view'
import { ArtistView } from './artist/artist-view'
import { ArtistTracksView } from './artist/artist-tracks-view'
import { ArtistProfilesView } from './artist/artist-profiles-view'
import { LoginView } from './static/login-view'
import { HomepageView } from './static/homepage-view'
import { ErrorView } from './static/error-view'

/**
 * @typedef {{ fetch: (function(): Promise<Page>), handle: (function(Page) ) }} View
 */

const views = {
  'static': StaticView,
  'artist': ArtistView,
  'artist-tracks': ArtistTracksView,
  'artist-profiles': ArtistProfilesView,
  'search': SearchView,
  'login': LoginView,
  'homepage': HomepageView,
  'error': ErrorView
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

  throw new Error(`unable to locate view with name ${name}`)
}
