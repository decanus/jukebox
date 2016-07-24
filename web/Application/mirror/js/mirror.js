/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { MasterFactory } from './factory/master-factory'
import { AppFactory } from './factory/app-factory'
import { ElementFactory } from './factory/element-factory'
import { PingMessage } from './message/ping-message'

const factory = new MasterFactory({ isDevelopmentMode: true })

factory.registerFactory(AppFactory)
factory.registerFactory(ElementFactory)

customElements.define('socket-debug', factory.createSocketDebugClass())

const socket = factory.createSocketWrapper()

// keep socket alive
setInterval(() => socket.send(PingMessage()), 30000)

