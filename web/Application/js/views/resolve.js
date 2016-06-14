/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page'
import { SearchView } from './search-view'
import { StaticView } from './static-view'
import { ArtistView } from './artist-view'
import { resolvePath } from '../app/apr'
import { app } from '../app'

/**
 * @typedef {{ fetch: (function(): Promise<Page>), handle: (function(Page) ) }} View
 */

/**
 * 
 * @param path
 * @returns {{ type: string, id: number }|null}
 */
async function resolveSpecial (path) {
  const resolved = await resolvePath(path)

  if (resolved.status === 404) {
    return null
  }

  const model = app.modelRepository.add(resolved)
  
  return getSpecialView(model)
}

/**
 *
 * @param {{ id: number, type: string }} model
 */
function getSpecialView (model) {
  switch (model.type) {
    case 'artists':
      return ArtistView(model.id)
    case 'tracks':
      return null
  }

  throw new Error(`no route for model with type ${model.type}`)
}

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

  return getSpecialView(cache.get(path))
}

/**
 *
 * @param {Route} route
 * @returns {View}
 */
export async function resolveView (route) {
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

  const special = await resolveSpecial(route.path)

  if (special) {
    // TODO: do something with special
  }

  return StaticView(new Page({
    title: 'Jukebox Ninja - Page Not Found',
    template: '404',
    data: { uri: route }
  }))
}
