/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { PlayerState } from '../../players/player-state'
import { ScrobbleBar } from '../../app/elements'

const player = app.player

export class PlayerScrobbleBar extends HTMLElement {
  createdCallback() {
    let playerState = PlayerState.STOPPED
    const $position = new ScrobbleBar()

    player.getState()
      .forEach((value) => (playerState = value))

    player.getTrack()
      .forEach(() => $position.reset())

    player.getDuration()
      .forEach((duration) => $position.setTotal(duration))

    player.getPosition()
      .forEach((value) => $position.setValue(value))

    $position.addEventListener('change', (event) => {
      if (playerState === PlayerState.STOPPED) {
        return
      }

      player.setPosition(event.detail.value)
    })

    this.appendChild($position)
  }
}
