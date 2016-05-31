/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Application } from './application.js'
import { PlayerDelegate } from './players/player-delegate'

/**
 * 
 * @type {Application}
 */
export const app = new Application(document, window, new PlayerDelegate())
