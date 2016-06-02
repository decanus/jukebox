import { JukeboxApp } from './elements/jukebox-app'
import { PlayerTitle } from './elements/player-title'
import { PlaylistPlayer } from './elements/playlist-player'
import { JukeboxLink } from './elements/link/jukebox-link'
import { ScrobbleBar as _ScrobbleBar } from './elements/scrobble-bar'
import { TrackLink } from './elements/link/track-link'
import { ToggleSidebar } from './elements/toggle-sidebar'
import { PlayerVolume } from './elements/player-volume'

/**
 * @type {Function}
 */
export const ScrobbleBar = document.registerElement('scrobble-bar', _ScrobbleBar)

document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('player-title', PlayerTitle)
document.registerElement('player-volume', PlayerVolume)
document.registerElement('playlist-player', PlaylistPlayer)
document.registerElement('track-link', TrackLink)

document.registerElement('toggle-sidebar', {
  'extends': 'button',
  prototype: ToggleSidebar.prototype
})

document.registerElement('jukebox-link', {
  'extends': 'a',
  prototype: JukeboxLink.prototype
})
