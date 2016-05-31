/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { Track } from './track/track'
import { app } from './app'

import { JukeboxApp } from './elements/jukebox-app'
import { PlayerTitle } from './elements/player-title'
import { PlaylistPlayer } from './elements/playlist-player'
import { JukeboxLink } from './elements/link/jukebox-link'
import { ScrobbleBar } from './elements/scrobble-bar'
import { TrackLink } from './elements/link/track-link'

document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('player-title', PlayerTitle)
document.registerElement('playlist-player', PlaylistPlayer)
document.registerElement('scrobble-bar', ScrobbleBar)
document.registerElement('track-link', TrackLink)
document.registerElement('jukebox-link', {
  'extends': 'a',
  prototype: JukeboxLink.prototype
})

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
}
