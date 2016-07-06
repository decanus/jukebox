/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { InsertIcon } from '../../app/elements'

export class PlayerVolumeButton extends HTMLElement {
  createdCallback() {
    this.$icon = new InsertIcon()
    this.$icon.className = '-normal'
    this.$icon.iconName = 'volume'

    this.appendChild(this.$icon)

    this.updateDom()
  }
}
