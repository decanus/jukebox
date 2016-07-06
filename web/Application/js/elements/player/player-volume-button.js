/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { InsertIcon, ScrobbleBar } from '../../app/elements'

export class PlayerVolumeButton extends HTMLElement {
  createdCallback () {

    const $icon = new InsertIcon()

    $icon.className = '-normal'
    $icon.iconName = 'volume'

    const $volume = new ScrobbleBar()

    $volume.setTotal(100)
    $volume.setValue(app.player.getCurrentVolume())

    app.player.getVolume().forEach((value) => {
      $volume.setValue(value)
    })

    $volume.addEventListener('change', (event) => {
      app.player.setVolume(event.detail.value)
    })

    this.appendChild($volume)
    this.appendChild($icon)
  }
}
