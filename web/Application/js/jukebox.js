/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'whatwg-fetch'

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './value/route'
import { sendPlayTrack } from './app/analytics'
import config from '../data/config.json'

import './app/elements'
import './app/media-keys'

window.addEventListener('popstate', () => {
  app.setRoute(Route.fromLocation(window.location))
})

// todo: idk where to put this
app.player
  .getTrack()
  .forEach((track) => sendPlayTrack(track))

window.__$loadModel = function (model) {
  app.modelRepository.add(model)
}

// todo: figure out an optimal interval for cleanup
getInterval(180000)
  .forEach(() => {

    if (window.localStorage.getItem('--no-cleanup') === '1') {
      //noinspection JSAccessibilityCheck
      console.info(`reaching a model count of ${Object.keys(app.modelRepository._store._store).length}`)
      return
    }

    console.info('it\'s time to clean')
    app.modelRepository.cleanup()
  })

//noinspection JSUnresolvedVariable
if (config.isDevelopmentMode === true) {
  window.__$app = app
}
