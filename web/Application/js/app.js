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
