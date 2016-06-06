/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './event/emitter'
import { updatePath, replacePath } from './dom/history'
import { ModelStore } from './model/model-store'
import { ModelLoader } from './model/model-loader'

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
     * @type {string} route
     */
    this._route = '/'

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

    /**
     *
     * @type {ModelStore}
     * @private
     */
    this._modelStore = new ModelStore()

    /**
     *
     * @type {ModelLoader}
     * @private
     */
    this._modelLoader = new ModelLoader(this._modelStore)

    this.getRoute().forEach((route) => (this._route = route))
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
    return this._emitter.toObservable('route')
  }

  /**
   *
   * @returns {string}
   */
  getCurrentRoute () {
    return this._route
  }
  
  /**
   *
   * @param {string} route
   * @param {boolean} replace
   */
  setRoute(route, { replace = false } = { replace: false }) {
    this._emitter.emit('route', route)
    
    if (replace) {
      replacePath(route)
    } else {
      updatePath(route)
    }
  }

  /**
   * 
   * @returns {ModelLoader}
   */
  getModelLoader () {
    return this._modelLoader
  }

  /**
   *
   * @returns {ModelStore}
   */
  getModelStore () {
    return this._modelStore
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
