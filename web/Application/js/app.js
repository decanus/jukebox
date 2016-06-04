/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Application } from './application.js'
import { PlayerDelegate } from './players/player-delegate'
import { Track } from './track/track'

/**
 * 
 * @type {Application}
 */
export const app = new Application(document, window, new PlayerDelegate())

const player = app.getPlayer()
player.addTrack(new Track(1, 'Christina Perri - A Thousand Years', 'Christina Perri', {youtubeId:'rtOvBOTyX00'}))
player.addTrack(new Track(0, 'Faded', 'Alan Walker', { youtubeId: '60ItHLz5WEA' }))
player.addTrack(new Track(1, 'The Night Is Still Young', 'Nicki Minaj', { youtubeId: 'IvN5h9BE444' }))
