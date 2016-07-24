/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PingMessage } from '../messages/ping-message'

/**
 * 
 * @param {MasterFactory|WrapperFactory} factory
 */
export function createSocketKeepAlive (factory) {
  const socket = factory.createSocketWrapper()
  
  setInterval(() => socket.send(PingMessage()), 30000)
}
