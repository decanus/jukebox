/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './../event/emitter'
import { updatePath } from './../dom/history'
import { ModelStore } from './../model/model-store'
import { ModelLoader } from './../model/model-loader'
import { ModelRepository } from './../model/model-repository'
import { ModelFetcher } from './../model/model-fetcher'
import { Route } from './route'
import { ResolveCache } from '../views/resolve-cache'

/**
 *
 * @param {ResolveCache} resolveCache
 * @returns {ModelRepository}
 */
function createModelRepository (resolveCache) {
  const store = new ModelStore()
  const loader = new ModelLoader(store, resolveCache)
  const fetcher = new ModelFetcher()

  return new ModelRepository(store, fetcher, loader)
}

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
     * @type {ResolveCache}
     * @private
     */
    this._resolveCache = new ResolveCache()

    /**
     *
     * @type {ModelRepository}
     * @private
     */
    this._modelRepository = createModelRepository(this._resolveCache)

    /**
     *
     * @type {ModelStore}
     * @private
     * @deprecated
     */
    this._modelStore = this._modelRepository._store

    /**
     *
     * @type {ModelLoader}
     * @private
     * @deprecated
     */
    this._modelLoader = this._modelRepository._loader

    // todo: change this
    this.getRoute().forEach((route) => (this._route = route))
  }

  /**
   * 
   * @returns {PlayerDelegator}
   * @deprecated
   */
  getPlayer() {
    return this._player
  }

  /**
   * 
   * @returns {PlayerDelegator}
   */
  get player () {
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
   * @param {boolean} silent
   */
  setRoute(route, { replace = false, silent = false } = {}) {
    this._emitter.emit('route', route)

    if (!silent) {
      updatePath(route, replace)
    }
  }

  reloadCurrentRoute () {
    this._emitter.emit('route', this._route)
  }

  /**
   * 
   * @returns {ModelLoader}
   * @deprecated
   * @see modelBackend
   */
  getModelLoader () {
    return this._modelLoader
  }

  /**
   *
   * @returns {ModelStore}
   * @deprecated
   * @see modelBackend
   */
  getModelStore () {
    return this._modelStore
  }

  /**
   *
   * @returns {ModelRepository}
   */
  get modelRepository () {
    return this._modelRepository
  }

  /**
   * 
   * @returns {ResolveCache}
   */
  get resolveCache () {
    return this._resolveCache
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
