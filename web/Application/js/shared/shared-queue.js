/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class SharedQueue {
  /**
   *
   * @param {MessagePort} port
   */
  constructor (port) {
    /**
     * 
     * @type {MessagePort}
     */
    this.port = port
  }
}
