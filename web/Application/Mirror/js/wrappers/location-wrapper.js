/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Uri } from './../library/value/uri'
import { Signal } from './../library/event/signal'
import { updatePath } from '../library/dom/history'

export class LocationWrapper {
  constructor () {
    /**
     *
     * @type {Uri}
     */
    this._uri = new Uri.fromLocation(window.location)

    /**
     *
     * @type {Signal<Uri>}
     */
    this.onUriChanged = new Signal()
  }

  /**
   *
   * @returns {Uri}
   */
  get uri () {
    return this._uri
  }

  /**
   *
   * @param {Uri} uri
   */
  set uri (uri) {
    this.setUri(uri)
  }

  /**
   *
   * @param {Uri} uri
   * @param {boolean} replace
   */
  setUri (uri, { replace = false } = {}) {
    if (uri.isSameValue(this._uri)) {
      return
    }

    this._uri = uri
    this.onUriChanged.dispatch(uri)

    updatePath(uri, replace)
  }

  registerPopstateListener () {
    window.addEventListener('popstate', () => {
      this.setUri(Uri.fromLocation(window.location))
    })
  }
}
