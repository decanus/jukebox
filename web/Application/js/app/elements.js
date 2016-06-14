/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { JukeboxApp } from '../elements/jukebox-app'
import { PlayerTitle } from '../elements/player/player-title'
import { JukeboxLink } from '../elements/link/jukebox-link'
import { ScrobbleBar as _ScrobbleBar } from '../elements/scrobble-bar'
import { TrackLink } from '../elements/link/track-link'
import { ToggleSidebar } from '../elements/toggle-sidebar'
import { PlayerVolume } from '../elements/player/player-volume'
import { PlayerRepeatButton } from  '../elements/player/player-repeat-button'
import { PlayerScrobbleBar } from  '../elements/player/player-scrobble-bar'
import { PlayerQueue } from  '../elements/player/player-queue'
import { PlayerControls } from  '../elements/player/player-controls'
import { PlayerQueueItem as _PlayerQueueItem} from  '../elements/player/player-queue-item'
import { SearchField } from  '../elements/search-field'
import { SearchPaginator } from  '../elements/search-paginator'
import { ListTrack } from  '../elements/list-track'


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
document.registerElement('track-link', TrackLink)
document.registerElement('player-queue', PlayerQueue)
document.registerElement('player-controls', PlayerControls)
document.registerElement('player-scrobble-bar', PlayerScrobbleBar)
document.registerElement('search-paginator', SearchPaginator)
document.registerElement('list-track', ListTrack)

document.registerElement('toggle-sidebar', {
  'extends': 'button',
  prototype: ToggleSidebar.prototype
})

document.registerElement('jukebox-link', {
  'extends': 'a',
  prototype: JukeboxLink.prototype
})

document.registerElement('search-field', {
  'extends': 'input',
  prototype: SearchField.prototype
})
