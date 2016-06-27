/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { AppMount } from '../elements/app/app-mount'
import { AppView as _AppView } from '../elements/app/app-view'
import { PlayerTitle } from '../elements/player/player-title'
import { JukeboxLink } from '../elements/link/jukebox-link'
import { ScrobbleBar as _ScrobbleBar } from '../elements/scrobble-bar'
import { QueueTrackLink } from '../elements/link/queue-track-link'
import { PlayTrackLink } from '../elements/link/play-track-link'
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
import { InsertIcon as _InsertIcon } from  '../elements/insert-icon'
import { TabLink } from  '../elements/tab/tab-link'
import { TabContent } from  '../elements/tab/tab-content'
import { SearchForm } from '../elements/search-form'

/**
 * @type {Function}
 */
export const AppView = document.registerElement('app-view', _AppView)

/**
 * @type {Function}
 */
export const ScrobbleBar = document.registerElement('scrobble-bar', _ScrobbleBar)

/**
 * @type {Function}
 */
export const PlayerQueueItem = document.registerElement('player-queue-item', _PlayerQueueItem)

/**
 * @type {Function}
 */
export const InsertIcon = document.registerElement('insert-icon', _InsertIcon)

document.registerElement('app-mount', AppMount)
document.registerElement('player-title', PlayerTitle)
document.registerElement('player-volume', PlayerVolume)
document.registerElement('player-repeat-button', PlayerRepeatButton)
document.registerElement('queue-track-link', QueueTrackLink)
document.registerElement('play-track-link', PlayTrackLink)
document.registerElement('player-queue', PlayerQueue)
document.registerElement('player-controls', PlayerControls)
document.registerElement('player-scrobble-bar', PlayerScrobbleBar)
document.registerElement('search-paginator', SearchPaginator)
document.registerElement('list-track', ListTrack)
document.registerElement('tab-link', TabLink)
document.registerElement('tab-content', TabContent)

document.registerElement('search-form', {
  'extends': 'form',
  prototype: SearchForm.prototype
})

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
