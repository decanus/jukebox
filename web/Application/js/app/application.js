/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { ModelStore } from './../model/model-store'
import { ModelLoader } from './../model/model-loader'
import { ModelRepository } from './../model/model-repository'
import { ModelFetcher } from './../model/model-fetcher'
import { Router } from './router'
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
     * @type {Router} route
     */
    this._router = new Router()

    /**
     *
     * @type {PlayerDelegator}
     * @private
     */
    this._player = player

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
   * @returns {Router}
   */
  get router () {
    return this._router
  }

  /**
   *
   * @returns {Route}
   * @deprecated
   */
  get route () {
    return this._router.route
  }

  /**
   *
   * @returns {Observable<Route>}
   * @deprecated
   */
  getRouteObservable () {
    return this._router.onRouteChanged.toObservable()
  }
  
  /**
   *
   * @param {Route} route
   * @param {boolean} replace
   * @param {boolean} silent
   * @deprecated
   */
  setRoute(route, { replace = false, silent = false } = {}) {
    this._router.setRoute(route, { replace, silent })
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

  /**
   *
   * @returns {HTMLElement}
   */
  get $main () {
    return this._document.querySelector('main')
  }

  /**
   * 
   * @returns {AppSidebar}
   */
  get $sidebar () {
    //noinspection JSValidateTypes
    return this._document.querySelector('app-sidebar')
  }
}
