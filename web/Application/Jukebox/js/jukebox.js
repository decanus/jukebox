/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from './app'
import * as config  from '../data/config.json'

import './app/init'
import './app/elements'
import './app/media-keys'

app.router.registerPopstateListener()
app.modelRepository.registerCleanupInterval()
app.analytics.registerTrackListener(app.player)

//noinspection JSUnresolvedVariable
if (config.isDevelopmentMode === true) {
  window.__$app = app
}
