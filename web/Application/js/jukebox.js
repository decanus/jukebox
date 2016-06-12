/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './app/route'
import { trackPageView } from './app/analytics'

import './app/elements'
import './app/media-keys'

window.addEventListener('popstate', () => {
  const route = Route.fromLocation(window.location)

  app.setRoute(route)
  trackPageView(route)
})

document.addEventListener('DOMContentLoaded', () => {
  app.setRoute(Route.fromLocation(window.location))
})

window.__$loadModel = function (model) {
  app.getModelLoader().load(model)
}

// todo: figure out an optimal interval for cleanup
getInterval(180000)
  .forEach(() => {
    console.info('it\'s time to clean')
    app.getModelStore().cleanup()
  })
