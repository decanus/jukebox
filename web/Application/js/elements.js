import { JukeboxApp } from './elements/jukebox-app'
import { PlayerTitle } from './elements/player-title'
import { PlaylistPlayer } from './elements/playlist-player'
import { JukeboxLink } from './elements/link/jukebox-link'
import { ScrobbleBar as _ScrobbleBar } from './elements/scrobble-bar'
import { TrackLink } from './elements/link/track-link'
import { ToggleSidebar } from './elements/toggle-sidebar'
import { PlayerVolume } from './elements/player-volume'
import { PlayerRepeatButton } from  './elements/player-repeat-button'
import { PlayerQueue } from  './elements/player-queue'
import { PlayerQueueItem as _PlayerQueueItem} from  './elements/player-queue-item'

/**
 * @type {Function}
 */
export const ScrobbleBar = document.registerElement('scrobble-bar', _ScrobbleBar)

/**
 * @type {Function}
 */
export const PlayerQueueItem = document.registerElement('player-queue-item', _PlayerQueueItem)

document.registerElement('jukebox-app', JukeboxApp)
document.registerElement('player-title', PlayerTitle)
document.registerElement('player-volume', PlayerVolume)
document.registerElement('player-repeat-button', PlayerRepeatButton)
document.registerElement('playlist-player', PlaylistPlayer)
document.registerElement('track-link', TrackLink)
document.registerElement('player-queue', PlayerQueue)

document.registerElement('toggle-sidebar', {
  'extends': 'button',
  prototype: ToggleSidebar.prototype
})

document.registerElement('jukebox-link', {
  'extends': 'a',
  prototype: JukeboxLink.prototype
})
