/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Application } from './app/application'
import { PlayerDelegator } from './players/player-delegator'
import { Analytics } from './app/analytics'

//noinspection JSUnresolvedVariable
import * as config from '../data/config.json'

const ga = window.ga || (() => {})

/**
 * 
 * @type {Application}
 */
export const app = new Application(document, new PlayerDelegator(), new Analytics(ga, config))
