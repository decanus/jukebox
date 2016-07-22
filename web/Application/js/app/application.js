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
   * @param {Analytics} analytics
   */
  constructor(document, player, analytics) {
    /**
     *
     * @type {Document}
     * @private
     */
    this._document = document

    /**
     *
     * @type {PlayerDelegator}
     * @private
     */
    this._player = player

    /**
     * 
     * @type {Analytics}
     * @private
     */
    this._analytics = analytics
    
    /**
     *
     * @type {Router} route
     */
    this._router = new Router(analytics)
    
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
   * @returns {Analytics}
   */
  get analytics () {
    return this._analytics
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
