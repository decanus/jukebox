/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {string} route
 * @returns {Promise<string>}
 * @todo connect to server instead of static routes?
 */
export function resolveRoute (route) {
  return new Promise((resolve) => {
    switch (route) {
      case '/':
        return resolve({title: 'Jukebox Ninja - Home', template: 'home'})
      case '/create':
        return resolve({title: 'Jukebox Ninja - Create Playlist', template: 'createPlaylist'})
      case '/lorem':
        return resolve({title: 'Jukebox Ninja - Lorem', template: 'lorem'})
    }

    resolve({title: 'Jukebox Ninja - Page Not Found', template: 'pageNotFound', data: {uri: route}})
  })
}
