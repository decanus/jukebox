/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './event/emitter'
import { updatePath } from './history/update-path'

export class Application {
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
   * @returns {PlayerDelegate}
   */
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

  showSidebar() {
    this._getAppLayout().classList.add('-sidebar-visible')
  }

  hideSidebar() {
    this._getAppLayout().classList.remove('-sidebar-visible')
  }

  toggleSidebar() {
    this._getAppLayout().classList.toggle('-sidebar-visible')
  }

  /**
   *
   * @returns {Element}
   * @private
   */
  _getAppLayout() {
    return this._document.querySelector('.app-layout')
  }
}
