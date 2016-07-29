/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

const Signal = require('./signal')

module.exports = class Client {
  /**
   *
   * @param {WebSocket} client
   */
  constructor (client) {
    /**
     *
     * @type {WebSocket}
     * @private
     */
    this._client = client

    /**
     *
     * @type {Signal}
     * @private
     */
    this._onDisconnect = new Signal()

    /**
     *
     * @type {Signal<{}>}
     * @private
     */
    this._onMessage = new Signal()

    client.on('close', () => {
      this._onDisconnect.dispatch()
      this._onDisconnect = null
      this._onMessage = null
      this._client = null
    })

    client.on('message', (msg) => this._onMessage.dispatch(JSON.parse(msg)))
  }

  /**
   *
   * @returns {Signal}
   */
  get onDisconnect () {
    return this._onDisconnect
  }

  /**
   *
   * @returns {Signal}
   */
  get onMessage () {
    return this._onMessage
  }

  /**
   *
   * @param {{}} message
   */
  send (message) {
    this.sendRaw(JSON.stringify(message))
  }

  /**
   *
   * @param {string} message
   */
  sendRaw (message) {
    this._client.send(message)
  }
}
