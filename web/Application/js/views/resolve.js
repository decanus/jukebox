/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page.js'
import { SearchView } from './search-view'
import { StaticView } from './static-view'

/**
 *
 * @param {string} route
 * @returns {{ fetch: (function(): Promise<Page>), handle: (function(Page) ) }}
 */
export function resolveView (route) {
  switch (route) {
    case '/':
      return StaticView(new Page({ title: 'Jukebox Ninja - Home', template: 'homepage' }))
    case '/create':
      return StaticView(new Page({ title: 'Jukebox Ninja - Create Playlist', template: 'createPlaylist' }))
    case '/lorem':
      return StaticView(new Page({ title: 'Jukebox Ninja - Lorem', template: 'lorem' }))
  }

  const parts = route.split('/')

  if (parts[ 1 ] === 'search') {
    return SearchView(decodeURIComponent(parts[ 2 ]))
  }

  return StaticView(new Page({
    title: 'Jukebox Ninja - Page Not Found',
    template: '404',
    data: { uri: route }
  }))
}
