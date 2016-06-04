/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { RepeatMode } from './../players/repeat-mode'

/**
 *
 * @param {number} current
 * @returns {number}
 */
function getNextMode(current) {
  switch(current) {
    case RepeatMode.NONE:
      return RepeatMode.QUEUE
    case RepeatMode.QUEUE:
      return RepeatMode.TRACK
  }

  return RepeatMode.NONE
}

/**
 *
 * @param {number} mode
 * @returns {string}
 */
function getIcon (mode) {
  switch(mode) {
    case RepeatMode.TRACK:
      return 'repeat-track'
    case RepeatMode.QUEUE:
      return 'repeat-colored'
  }

  return 'repeat-white'
}

const player = app.getPlayer()

export class PlayerRepeatButton extends HTMLElement {
  createdCallback() {
    this.$icon = this.ownerDocument.createElement('img')
    this.appendChild(this.$icon)
    
    this.addEventListener('click', () => {
      player.setRepeatMode(getNextMode(player.getCurrentRepeatMode()))
      this.updateDom()
    })
    
    this.updateDom()
  }

  updateDom () {
    this.$icon.src = `/images/icons/${getIcon(player.getCurrentRepeatMode())}.svg`
  }
}
