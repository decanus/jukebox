/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { app } from './app'

import './app/elements'

window.addEventListener('popstate', () => {
  app.setRoute(window.location.pathname)
})

document.addEventListener('DOMContentLoaded', () => {
  app.setRoute(window.location.pathname)
})

window.__$loadModel = function (model) {
  app.getModelLoader().load(model)
}

// todo: periodically cleanup models
