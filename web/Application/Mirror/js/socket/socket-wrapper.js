/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Signal } from '../event/signal'

export class SocketWrapper {
  /**
   *
   * @param {string} url
   * @param {number} [reconnectInterval]
   */
  constructor (url, reconnectInterval = 5000) {
    this._url = url
    this._reconnectInterval = reconnectInterval
    this._onMessage = new Signal()
    this._open = false
    this._messages = new Set()

    this._onSocketOpen = this._onSocketOpen.bind(this)
    this._onSocketClose = this._onSocketClose.bind(this)
    this._onSocketMessage = this._onSocketMessage.bind(this)
  }

  _onSocketOpen () {
    this._open = true

    this._messages.forEach((msg) => this.send(msg))
    this._messages = new Set()
  }

  _onSocketClose () {
    this._open = false

    console.info('connection lost, reconnecting after short delay...')

    setTimeout(() => this.connect(), this._reconnectInterval)
  }

  /**
   *
   * @param {MessageEvent} event
   * @private
   */
  _onSocketMessage(event) {
    this._onMessage.dispatch(JSON.parse(event.data))
  }

  /**
   *
   * @returns {Signal}
   */
  get onMessage () {
    return this._onMessage
  }

  connect () {
    this._socket = new WebSocket(this._url)

    this._socket.addEventListener('open', this._onSocketOpen)
    this._socket.addEventListener('close', this._onSocketClose)
    this._socket.addEventListener('message', this._onSocketMessage)
  }

  /**
   *
   * @param {{}} message
   */
  send (message) {
    if (!this._open) {
      this._messages.add(message)
      return
    }

    this._socket.send(JSON.stringify(message))
  }
}
