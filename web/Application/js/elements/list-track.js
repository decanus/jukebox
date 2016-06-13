/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { renderTemplate } from '../render-template'

const subscription = new WeakMap()

export class ListTrack extends HTMLElement {
  createdCallback () {
    const track = this.track

    this.appendChild(renderTemplate('partials/list-track', this.ownerDocument, track))
    this.active = (track.id === app.player.getCurrentTrack().id)
  }

  attachedCallback () {
    var _this = this

    let sub = app.player.getTrack().subscribe({
      next (track) {
        _this.active = (track.id === _this.track.id)
      },
      complete () {
        subscription.delete(_this)
      }
    })

    subscription.set(this, sub)
  }

  detachedCallback () {
    if (!subscription.has(this)) {
      return
    }

    subscription.get(this).unsubscribe()
  }

  /**
   *
   * @returns {string}
   */
  get trackId () {
    return this.getAttribute('track-id')
  }

  /**
   *
   * @returns {Track}
   */
  get track () {
    return app.getModelStore().getTrack(Number.parseInt(this.trackId))
  }

  /**
   *
   * @param {boolean} value
   */
  set active (value) {
    const $ = this.querySelector('.search-result')

    if (value) {
      $.classList.add('-active')
    } else {
      $.classList.remove('-active')
    }
  }
}
