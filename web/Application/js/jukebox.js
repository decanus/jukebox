/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { Track } from './track/track'
import { app } from './app'

import './elements'

window.addEventListener('popstate', () => {
  app.setRoute(window.location.pathname)
})

document.addEventListener('DOMContentLoaded', () => {
  app.setRoute(window.location.pathname)
})

// todo: remove this after everything is working again
if (process.env['JUKEBOX_ENV'] !== 'production') {
  window.app = app
  window.Track = Track
  window.player = app.getPlayer()
}
