/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { JukeboxApp } from './elements/jukebox-app'
import { JukeboxLink } from './elements/link/jukebox-link'
import { PlaylistPlayer } from './elements/playlist-player'
import { TrackLink } from './elements/link/track-link'
import { PlayerTitle } from './elements/player-title'
import { player } from './player'
import { Track } from './track/track'

// register custom elements
document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('playlist-player', PlaylistPlayer)

document.registerElement('track-link', TrackLink)
document.registerElement('jukebox-link', {
  prototype: JukeboxLink.prototype,
  'extends': 'a'
})

document.registerElement('player-title', PlayerTitle)

Object.defineProperty(window, '_SUPER_SECRET_DO_NOT_TOUCH', {
  get() {
    player.removeAllTracks()
      .then(() => player.addTrack(new Track(666, 'Baby', { youtubeId: 'kffacxfA7G4' })))
      .then(() => player.play())
  }
})
