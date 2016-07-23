/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { ScrobbleBar } from '../../app/elements'

const player = app.player

export class PlayerVolume extends HTMLElement {
  createdCallback() {
    const $volume = new ScrobbleBar()
    
    $volume.setTotal(100)
    $volume.setValue(player.getCurrentVolume())

    player.getVolume().forEach((value) => {
      $volume.setValue(value)
    })

    $volume.addEventListener('change', (event) => {
      player.setVolume(event.detail.value)
    })

    this.appendChild($volume)
  }
}
