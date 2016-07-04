/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

let currentNotification

/**
 *
 * @returns {Promise}
 */
function requestPermission () {
  return new Promise((resolve) => {
    const promise = Notification.requestPermission(resolve)

    if (promise instanceof Promise) {
      resolve(promise)
    }
  })
}

(async () => {

  const permission = await requestPermission()

  if (permission !== 'granted') {
    return
  }

  app.player
    .getTrack()
    .filter(() => !!document.hidden)
    .forEach((track) => {
      if (currentNotification) {
        currentNotification.close()
      }
      
      const artistName = track.mainArtist.name

      currentNotification = new Notification(track.title, {
        body: artistName,
        icon: '/images/favicon-152.png',
        silent: true
      })
    })
})()
