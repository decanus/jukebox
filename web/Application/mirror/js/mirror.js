/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import './app/elements'

import { SocketWrapper } from './socket/socket-wrapper'
import { SubscribeMessage } from './message/subscribe-message'
import { PingMessage } from './message/ping-message'

const socket = new SocketWrapper('ws://devsocket.jukebox.ninja/mirror')

socket.connect()

socket.onMessage.addListener((msg) => {
  console.log(msg)
})

socket.send(SubscribeMessage('1'))

// keep socket alive
setInterval(() => socket.send(PingMessage()), 30000)
