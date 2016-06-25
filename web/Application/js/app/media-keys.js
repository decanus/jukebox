/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { PlayerState } from '../players/player-state'

let state = PlayerState.STOPPED
const player = app.player

player.getState().forEach((value) => (state = value))

/**
 *
 * @returns {Promise}
 */
function playPause () {
  if (state == PlayerState.PLAYING) {
    return player.pause()
  }

  return player.play()
}

document.addEventListener('jukeboxMediaKey', (event) => {
  const command = event.detail.command

  switch(command) {
    case 'pause':
      return playPause()
    case 'next':
      return player.next()
    case 'prev':
      return player.prev()
    case 'stop':
      return player.stop()
  }
})
