/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { SocketDebug } from '../elements/socket-debug'

export class ElementFactory {
  /**
   *
   * @param {MasterFactory} masterFactory
   */
  constructor (masterFactory) {
    this._masterFactory = masterFactory
  }

  /**
   *
   * @returns {Array<string>}
   */
  static get factoryMethods () {
    return [
      'createSocketDebugClass'
    ]
  }

  /**
   *
   * @returns {AppMount}
   */
  createSocketDebugClass () {
    //noinspection JSUnresolvedFunction
    return this._wrapElementClass(SocketDebug, (name) => [
      this._masterFactory.createSocketWrapper()
    ])
  }

  /**
   *
   * @template T
   * @param {T} Element
   * @param {(function():Array)} constructorArgs
   * @returns {T}
   * @private
   */
  _wrapElementClass (Element, constructorArgs) {
    return class extends Element {
      constructor () {
        super(...constructorArgs())
      }
    }
  }
}
