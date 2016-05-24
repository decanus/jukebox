/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'
import './_SUPER_SECRET/SECRET'

import { JukeboxApp } from './elements/jukebox-app'
import { JukeboxLink } from './elements/link/jukebox-link'
import { PlaylistPlayer } from './elements/playlist-player'
import { TrackLink } from './elements/link/track-link'
import { PlayerTitle } from './elements/player-title'

// register custom elements
document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('playlist-player', PlaylistPlayer)

document.registerElement('track-link', TrackLink)
document.registerElement('jukebox-link', {
  prototype: JukeboxLink.prototype,
  'extends': 'a'
})

document.registerElement('player-title', PlayerTitle)
