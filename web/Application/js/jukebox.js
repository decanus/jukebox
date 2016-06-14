/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './app/route'
import { trackPageView, sendPlayTrack } from './app/analytics'

import './app/elements'
import './app/media-keys'

window.addEventListener('popstate', () => {
  app.setRoute(Route.fromLocation(window.location))
})

document.addEventListener('DOMContentLoaded', () => {
  // todo: make listeners use getCurrentRoute() the first time and remove this
  app.setRoute(Route.fromLocation(window.location))

  app.getRoute().forEach(trackPageView)
})

app.getPlayer()
  .getTrack()
  .forEach((track) => sendPlayTrack(track))

window.__$loadModel = function (model) {
  app.modelRepository.add(model)
}

// todo: figure out an optimal interval for cleanup
getInterval(180000)
  .forEach(() => {
    console.info('it\'s time to clean')
    app.modelRepository.cleanup()
  })

window.repository = app.modelRepository
