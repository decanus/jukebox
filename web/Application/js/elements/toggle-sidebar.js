/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { PlayerState } from '../players/player-state'

const player = app.getPlayer()

export class ToggleSidebar extends HTMLButtonElement {
  createdCallback () {
    const $icon = this.querySelector('.audio-icon')

    this.addEventListener('click', () => {
      app.toggleSidebar()
    })

    player.getState()
      .filter((state) => state !== PlayerState.STOPPED)
      .once()
      .then(() => {
        app.showSidebar()
        this.hidden = false
      })

    player.getState()
      .forEach((state) => {
        if (state === PlayerState.PLAYING) {
          $icon.classList.remove('-paused')
        } else {
          $icon.classList.add('-paused')
        }
      })
  }

  /**
   *
   * @param {boolean} hidden
   */
  set hidden (hidden) {
    if (hidden) {
      this.setAttribute('hidden', 'hidden')
    } else {
      this.removeAttribute('hidden')
    }
  }

  /**
   *
   * @returns {boolean}
   */
  get hidden () {
    return this.hasAttribute('hidden')
  }
}
