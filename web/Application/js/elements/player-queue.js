/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { PlayerQueueItem } from '../elements'

const player = app.getPlayer()

export class PlayerQueue extends HTMLElement {
  createdCallback () {
    player.getQueueChange()
      .forEach(() => this.updateDom())

    player.getTrack()
      .forEach(() => {
        this.updateDom()
      })
  }
  
  updateDom () {
    this.innerHTML = ''
    
    player.getTracks()
      .forEach((track, index) => {
        const $queueItem = new PlayerQueueItem()
        
        $queueItem.init(track, index)
        
        this.appendChild($queueItem)
      })
  }
}
