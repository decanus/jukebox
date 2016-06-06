/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page.js'
import { searchHandler } from '../handlers/search-handler'

/**
 *
 * @param {string} route
 * @returns {Promise<Page>}
 * @todo connect to server instead of static routes?
 */
export function resolveRoute (route) {
  return new Promise((resolve) => {
    switch (route) {
      case '/':
        return resolve(new Page({ title: 'Jukebox Ninja - Home', template: 'homepage' }))
      case '/create':
        return resolve(new Page({ title: 'Jukebox Ninja - Create Playlist', template: 'createPlaylist' }))
      case '/lorem':
        return resolve(new Page({ title: 'Jukebox Ninja - Lorem', template: 'lorem' }))
    }

    const parts = route.split('/')

    if (parts[1] === 'search') {
      return resolve(searchHandler(decodeURIComponent(parts[2])))
    }

    resolve(new Page({
      title: 'Jukebox Ninja - Page Not Found',
      template: '404',
      data: { uri: route }
    }))
  })
}
