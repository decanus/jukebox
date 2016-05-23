/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page.js'

/**
 *
 * @param {string} route
 * @returns {Promise<Page>}
 * @todo connect to server instead of static routes?
 */
export function resolveRoute(route) {
  return new Promise((resolve) => {
    switch (route) {
      case '/':
        return resolve(new Page({title: 'Jukebox Ninja - Home', template: 'home', showSidebar: false}))
      case '/create':
        return resolve(new Page({title: 'Jukebox Ninja - Create Playlist', template: 'createPlaylist'}))
      case '/lorem':
        return resolve(new Page({title: 'Jukebox Ninja - Lorem', template: 'lorem'}))
    }

    resolve(new Page({
      title: 'Jukebox Ninja - Page Not Found',
      template: 'pageNotFound',
      data: { uri: route }
    }))
  })
}
