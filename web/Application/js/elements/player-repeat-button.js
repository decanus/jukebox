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
function getTextRepresentation (mode) {
  switch(mode) {
    case RepeatMode.TRACK:
      return 'track'
    case RepeatMode.QUEUE:
      return 'queue'
  }

  return 'none'
}

const player = app.getPlayer()

export class PlayerRepeatButton extends HTMLElement {
  createdCallback() {
    this.addEventListener('click', () => {
      player.setRepeatMode(getNextMode(player.getCurrentRepeatMode()))
      this.updateDom()
    })
    
    this.updateDom()
  }

  updateDom () {
    this.innerText = getTextRepresentation(player.getCurrentRepeatMode())
  }
}
