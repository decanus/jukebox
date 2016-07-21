/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Emitter } from './../event/emitter'
import { Signal } from './../event/signal'
import { updatePath } from './../dom/history'
import { ModelStore } from './../model/model-store'
import { ModelLoader } from './../model/model-loader'
import { ModelRepository } from './../model/model-repository'
import { ModelFetcher } from './../model/model-fetcher'
import { Route } from './../value/route'
import { ResolveCache } from '../views/resolve-cache'
import { trackPageView } from './analytics'

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
  constructor (document, player) {
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
    this._route = new Route.fromLocation(window.location)

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
     * @type {User}
     * @private
     */
    this._user = null

    /**
     *
     * @type {Signal<void>}
     */
    this.onUserChange = new Signal()
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
   * @returns {Route}
   */
  get route () {
    return this._route
  }

  /**
   *
   * @returns {User}
   */
  get user () {
    return this._user
  }

  /**
   *
   * @param {User} user
   */
  set user (user) {
    this._user = user
    this.onUserChange.dispatch()
  }

  /**
   *
   * @returns {Observable<Route>}
   */
  getRouteObservable () {
    return this._emitter.toObservable('route')
  }

  /**
   *
   * @param {Route} route
   * @param {boolean} replace
   * @param {boolean} silent
   */
  setRoute (route, { replace = false, silent = false } = {}) {
    if (route.isSameValue(this._route)) {
      return
    }

    this._route = route
    this._emitter.emit('route', route)

    if (!silent) {
      updatePath(route, replace)
    }

    trackPageView(route)
  }

  reloadCurrentRoute () {
    this._emitter.emit('route', this._route)
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
