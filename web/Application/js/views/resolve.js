/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page'
import { SearchView } from './search-view'
import { StaticView } from './static-view'
import { ArtistView } from './artist-view'
import { app } from '../app'

/**
 * @typedef {{ fetch: (function(): Promise<Page>), handle: (function(Page) ) }} View
 */

/**
 *
 * @param {Route} route
 * @returns {View}
 */
function resolveCached (route) {
  const cache = app.resolveCache
  const path = route.path

  if (!cache.has(path)) {
    //noinspection JSValidateTypes
    return
  }

  const cached = cache.get(path)

  switch (cached.type) {
    case 'artists':
      return ArtistView(cached.id)
    case 'tracks':
      // TODO
  }
}

/**
 *
 * @param {Route} route
 * @returns {View}
 */
export function resolveView (route) {
  const cached = resolveCached(route)

  if (cached) {
    return cached
  }

  switch (route.path) {
    case '/':
      return StaticView(new Page({ title: 'Jukebox Ninja - Home', template: 'homepage' }))
    case '/create':
      return StaticView(new Page({ title: 'Jukebox Ninja - Create Playlist', template: 'createPlaylist' }))
    case '/lorem':
      return StaticView(new Page({ title: 'Jukebox Ninja - Lorem', template: 'lorem' }))
    case '/error':
      return StaticView(new Page({ title: 'Jukebox Ninja - Error', template: 'error' }))
  }

  if (route.pathParts[ 0 ] === 'search') {
    return SearchView(route.params.get('q') || '')
  }

  return StaticView(new Page({
    title: 'Jukebox Ninja - Page Not Found',
    template: '404',
    data: { uri: route }
  }))
}
