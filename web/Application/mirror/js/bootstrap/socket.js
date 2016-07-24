/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PingMessage } from '../message/ping-message'

/**
 * 
 * @param {MasterFactory|AppFactory} factory
 */
export function createSocketKeepAlive (factory) {
  const socket = factory.createSocketWrapper()
  
  setInterval(() => socket.send(PingMessage()), 30000)
}
