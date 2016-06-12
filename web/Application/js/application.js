/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './event/emitter'
import { updatePath, replacePath } from './dom/history'
import { ModelStore } from './model/model-store'
import { ModelLoader } from './model/model-loader'
import { Route } from './app/route'

export class Application {
  /**
   *
   * @param {Document} document
   * @param {PlayerDelegator} player
   */
  constructor(document, player) {
    /**
     *
     * @type {Document}
     * @private
     */
    this._document = document

    /**
     *
     * @type {Route} route
     */
    this._route = new Route('/')

    /**
     *
     * @type {PlayerDelegator}
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
   * @returns {PlayerDelegator}
   */
  getPlayer() {
    return this._player
  }

  /**
   *
   * @returns {Observable<Route>}
   */
  getRoute() {
    return this._emitter.toObservable('route')
  }

  /**
   *
   * @returns {Route}
   */
  getCurrentRoute () {
    return this._route
  }
  
  /**
   *
   * @param {Route} route
   * @param {boolean} replace
   */
  setRoute(route, { replace = false } = { replace: false }) {
    this._emitter.emit('route', route)
    
    updatePath(route, replace)
  }

  reloadCurrentRoute () {
    this._emitter.emit('route', this._route)
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
