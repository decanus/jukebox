/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { SocketWrapper } from '../socket/socket-wrapper'

export class AppFactory {
  /**
   *
   * @param {MasterFactory} masterFactory
   */
  constructor (masterFactory) {
    /**
     *
     * @type {MasterFactory}
     * @private
     */
    this._masterFactory = masterFactory

    /**
     *
     * @type {SocketWrapper}
     * @private
     */
    this._socket = null
  }

  /**
   *
   * @returns {SocketWrapper}
   */
  createSocketWrapper () {
    if (this._socket == null) {
      // todo: read from config
      this._socket = new SocketWrapper('ws://devsocket.jukebox.ninja/mirror')
      this._socket.connect()
    }

    return this._socket
  }

  /**
   * 
   * @returns {Array<String>}
   */
  static get factoryMethods () {
    return [ 'createSocketWrapper' ]
  }
}
