/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { RepeatMode } from './../../players/repeat-mode'
import { InsertIcon, PlayerQueueItem } from '../../app/elements'

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
      return 'repeat'
  }

  return 'repeat'
}

const player = app.getPlayer()

export class PlayerRepeatButton extends HTMLElement {
  createdCallback() {
    this.$icon = new InsertIcon()
    this.$icon.className = '-normal'
    this.appendChild(this.$icon)
    
    this.addEventListener('click', () => {
      player.setRepeatMode(getNextMode(player.getCurrentRepeatMode()))
      this.updateDom()
    })
    
    this.updateDom()
  }

  updateDom () {
    const currentRepeatMode = player.getCurrentRepeatMode()
    
    this.$icon.iconName = getIcon(currentRepeatMode)
    
    if (currentRepeatMode === RepeatMode.NONE) {
      this.$icon.classList.remove('-brand-color')
    } else {
      this.$icon.classList.add('-brand-color')
    }
  }
}
