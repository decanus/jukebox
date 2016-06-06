/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { PlayerState } from '../players/player-state'

const player = app.getPlayer()

export class ToggleSidebar extends HTMLButtonElement {
  createdCallback () {
    this.addEventListener('click', () => {
      app.toggleSidebar()
    })

    player.getState()
      .forEach((state) => {
        this.hidden = (state === PlayerState.STOPPED)
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
