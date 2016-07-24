/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { buildFactory } from './bootstrap/factory'
import { defineElements } from './bootstrap/elements'
import { createSocketKeepAlive } from './bootstrap/socket'

const factory = buildFactory()

defineElements(factory)
createSocketKeepAlive(factory)
