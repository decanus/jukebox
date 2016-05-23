/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'babel-polyfill'
import 'es6-symbol/implement'

import { JukeboxApp } from './elements/jukebox-app'
import { JukeboxLink } from './elements/jukebox-link'
import { PlaylistPlayer } from './elements/playlist-player'

// register custom elements
document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('playlist-player', PlaylistPlayer)

document.registerElement('jukebox-link', {
  prototype: JukeboxLink.prototype,
  'extends': 'a'
})
