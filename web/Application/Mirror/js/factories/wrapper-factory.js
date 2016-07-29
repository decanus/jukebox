/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { SocketWrapper } from '../wrappers/socket-wrapper'
import { LocationWrapper } from '../wrappers/location-wrapper'

export class WrapperFactory {
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

    /**
     * 
     * @type {LocationWrapper}
     * @private
     */
    this._locationWrapper = null
  }

  /**
   *
   * @returns {Array<String>}
   */
  static get factoryMethods () {
    return [ 'createSocketWrapper', 'createLocationWrapper' ]
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
   * @returns {LocationWrapper}
   */
  createLocationWrapper () {
    if (this._router == null) {
      this._locationWrapper = new LocationWrapper()
      this._locationWrapper.registerPopstateListener()
    }
    
    return this._locationWrapper
  }
}
