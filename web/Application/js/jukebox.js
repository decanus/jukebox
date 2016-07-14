/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import '../node_modules/whatwg-fetch'
import '../node_modules/regenerator-runtime/runtime'

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './value/route'
import { sendPlayTrack } from './app/analytics'
import config from '../data/config.json'

import './app/init'
import './app/elements'
import './app/media-keys'

window.addEventListener('popstate', () => {
  app.setRoute(Route.fromLocation(window.location))
})

// todo: idk where to put this
app.player
  .getTrack()
  .forEach((track) => sendPlayTrack(track))

// todo: figure out an optimal interval for cleanup
getInterval(180000)
  .forEach(() => {
    console.info('it\'s time to clean')
    app.modelRepository.cleanup()
  })

//noinspection JSUnresolvedVariable
if (config.isDevelopmentMode === true) {
  window.__$app = app
}
