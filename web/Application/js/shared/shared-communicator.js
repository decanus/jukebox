/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createObservable } from '../dom/events/create-observable'
import { app } from '../app'

export class SharedCommunicator {
  /**
   *
   * @param {MessagePort} port
   */
  constructor (port) {
    /**
     * 
     * @type {MessagePort}
     */
    this._port = port
  }

  /**
   *
   * @returns {Observable}
   */
  getMessages () {
    return createObservable(this._port, 'message')
      .map((e) => e.data)
  }

  /**
   *
   * @returns {Observable}
   */
  getPushes () {
    return this.getMessages()
      .filter((msg) => msg.type === 'push' && msg.source !== app.instanceId)
  }

  /**
   *
   * @returns {Observable}
   */
  getPlayPushes () {
    return this.getPushes()
      .filter((msg) => msg.action === 'play')
  }

  /**
   *
   * @returns {Observable}
   */
  getQueueTrackPushes () {
    return this.getPushes()
      .filter((msg) => msg.action === 'queue-track')
  }

  /**
   *
   * @param {string} type
   * @param {string} action
   * @param {{}} data
   */
  push (type, action, data = {}) {
    this._port.postMessage({ type, action, data, source: app.instanceId })
  }

  pushClosing () {
    this.push('closing', '')
  }

  pushPlay () {
    this.push('push', 'play')
  }

  /**
   *
   * @param {Track} track
   */
  pushQueueTrack (track) {
    this.push('push', 'queue-track', { id: track.id })
  }
}
