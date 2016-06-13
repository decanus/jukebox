/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Application } from './app/application.js'
import { PlayerDelegator } from './players/player-delegator'

/**
 * 
 * @type {Application}
 */
export const app = new Application(document, new PlayerDelegator())
