/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

module.exports = SubscriptionManager

class SubscriptionManager {
  /**
   *
   * @param {RedisClient} redisClient
   */
  constructor (redisClient) {
    /**
     *
     * @type {RedisClient}
     * @private
     */
    this._redisClient = redisClient

    /**
     * maps client => mirror
     * @type {Map<WebSocket, string>}
     * @private
     */
    this._mirrors = new Map()

    /**
     *
     * maps mirror => clients
     * @type {Map<string, Set<WebSocket>>}
     * @private
     */
    this._clients = new Map()
  }

  /**
   *
   * @param {WebSocket} client
   * @param {string} mirrorId
   */
  subscribe (client, mirrorId) {
    let clients = this._clients.get(mirrorId)

    if (clients === null) {
      clients = new Set()

      this._clients.set(mirrorId, clients)
      this._redisClient.subscribe(`mirror_${mirrorId}`)
    }

    clients.add(client)
    this._mirrors.set(client, mirrorId)
  }

  /**
   *
   * @param {WebSocket} client
   */
  unsubscribe (client) {
    const mirrorId = this._mirrors.get(client)
    const clients = this._clients.get(mirrorId)

    this._mirrors.delete(client)
    clients.delete(client)

    if (clients.size === 0) {
      this._clients.delete(mirrorId)
      this._redisClient.unsubscribe(`mirror_${mirrorId}`)
    }
  }
}
