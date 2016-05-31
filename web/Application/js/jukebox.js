/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import Application from './application'
import { PlayerDelegate } from './players/player-delegate'
import { Track } from './track/track'
import { CustomElementFactory  } from './factories/custom-element-factory'
import { CustomElementProtoFactory  } from './factories/custom-element-proto-factory'

import { createJukeboxApp } from './elements/jukebox-app'
import { createPlayerTitle } from './elements/player-title'
import { createPlaylistPlayer } from './elements/playlist-player'
import { createJukeboxLink } from './elements/link/jukebox-link'

const player = new PlayerDelegate()
const app = new Application(document, window, player)

const customElementFactory = new CustomElementFactory(app)
const customElementProtoFactory = new CustomElementProtoFactory(customElementFactory)

app.registerElement('jukebox-app', createJukeboxApp)
app.registerElement('player-title', createPlayerTitle)
app.registerElement('playlist-player', createPlaylistPlayer)
app.newRegisterElement('scrobble-bar', customElementProtoFactory.createScrobbleBar())
app.extendElement('a', 'jukebox-link', createJukeboxLink)

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

document.addEventListener('DOMContentLoaded', () => {

  const $scrobbleBar = document.createElement('scrobble-bar')

  document.body.appendChild($scrobbleBar)

  console.log(customElementProtoFactory.unwrap($scrobbleBar))

})
