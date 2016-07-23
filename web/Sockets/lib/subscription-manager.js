/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

module.exports = class SubscriptionManager {
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
     * @type {Map<Client, string>}
     * @private
     */
    this._mirrors = new Map()

    /**
     *
     * maps mirror => clients
     * @type {Map<string, Set<Client>>}
     * @private
     */
    this._clients = new Map()
  }

  /**
   *
   * @param {Client} client
   * @param {string} mirrorId
   */
  subscribe (client, mirrorId) {
    mirrorId = `mirror_${mirrorId}`
    
    this.unsubscribe(client)
    
    let clients = this._clients.get(mirrorId)

    if (clients == null) {
      clients = new Set()

      this._clients.set(mirrorId, clients)
      this._redisClient.subscribe(mirrorId)
    }

    clients.add(client)
    this._mirrors.set(client, mirrorId)
  }

  /**
   *
   * @param {Client} client
   */
  unsubscribe (client) {
    const mirrorId = this._mirrors.get(client)
    const clients = this._clients.get(mirrorId)

    this._mirrors.delete(client)
    
    if (clients == null) {
      return
    }
    
    clients.delete(client)

    if (clients.size === 0) {
      this._clients.delete(mirrorId)
      this._redisClient.unsubscribe(mirrorId)
    }
  }

  /**
   *
   * @param {string} mirrorId
   * @param {{}} message
   */
  broadcast (mirrorId, message) {
    const clients = this._clients.get(mirrorId)

    clients.forEach((client) => client.send(message))
  }

  /**
   *
   * @param {string} mirrorId
   * @param {string} message
   */
  broadcastRaw (mirrorId, message) {
    const clients = this._clients.get(mirrorId)

    console.log(mirrorId, message, this)
    
    if (clients == null) {
      return
    }

    clients.forEach((client) => client.sendRaw(message))
  }
}
