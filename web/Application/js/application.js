/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './event/emitter'
import { updatePath } from './history/update-path'

export default class Application {
  /**
   *
   * @param {Document} document
   * @param {Window} view
   * @param {PlayerDelegate} player
   */
  constructor(document, view, player) {
    /**
     *
     * @type {Document}
     * @private
     */
    this._document = document

    /**
     *
     * @type {Window}
     * @private
     */
    this._view = view

    /**
     *
     * @type {PlayerDelegate}
     * @private
     */
    this._player = player

    /**
     *
     * @type {Emitter}
     * @private
     */
    this._emitter = new Emitter()
  }

  /**
   *
   * @param {string} tagName
   * @param {Function} createPrototype
   */
  registerElement(tagName, createPrototype) {
    const Element = createPrototype(this)

    this._document.registerElement(tagName, {
      prototype: Element
    })
  }

  getPlayer() {
    return this._player
  }

  /**
   *
   * @returns {Observable<string>}
   */
  getRoute() {
    return Emitter.toObservable(this._emitter, 'route')
  }
  
  /**
   *
   * @param {string} route
   */
  setRoute(route) {
    this._emitter.emit('route', route)
    updatePath(route)
  }
}
