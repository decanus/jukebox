/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { renderTemplate } from '../render-template'

const subscription = new WeakMap()

export class ListTrack extends HTMLElement {
  async createdCallback () {
    const track = await this.track
    const currentTrack = app.player.getCurrentTrack()

    this.appendChild(renderTemplate('partials/list-track', this.ownerDocument, track))
    this.active = (currentTrack && track.id === currentTrack.id)

    if (this.isFirst) {
      this.querySelector('.search-result').classList.add('-first')
    }
  }

  attachedCallback () {
    var _this = this

    let sub = app.player.getTrack().subscribe({
      async next (track) {
        _this.active = (track.id === (await _this.track).id)
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
   * @returns {Promise<Track>}
   */
  get track () {
    return app.modelRepository.getTrack(Number.parseInt(this.trackId))
  }

  /**
   *
   * @returns {boolean}
   */
  get isFirst () {
    return this.hasAttribute('is-first')
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
