/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'whatwg-fetch'

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './app/route'
import { trackPageView, sendPlayTrack } from './app/analytics'
import config from '../data/config.json'

import './app/elements'
import './app/media-keys'
import './app/settings'

window.addEventListener('popstate', () => {
  app.setRoute(Route.fromLocation(window.location))
})

document.addEventListener('DOMContentLoaded', () => {
  // todo: make listeners use getCurrentRoute() the first time and remove this
  app.setRoute(Route.fromLocation(window.location))

  app.getRoute().forEach(trackPageView)
})

app.player
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

//noinspection JSUnresolvedVariable
if (config.isDevelopmentMode === true) {
  window.__$app = app
}

const worker = new SharedWorker('/js/shared-worker.js', 'Jukebox Ninja')

worker.port.addEventListener('message', (event) => {
  console.log('counter', event.data)
})

worker.port.start()

window.worker = worker

// todo: put this idk where
Handlebars.registerHelper('json', function (context) {
  return JSON.stringify(context)
})

// todo: put this idk where
Handlebars.registerHelper('debug', function (ctx) {
  console.log(ctx)
})
