/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { Observable } from '../../observable'
import { renderTemplate } from '../../render-template'

export class PlayerQueue extends HTMLElement {
  // todo: move subscriptions to attached/detached callback
  createdCallback () {
    const update = Observable.merge(
      app.player.getQueueChange(),
      app.player.getTrack()
    )

    update.forEach(() => this.updateDom())
  }
  
  updateDom () {
    const queue = app.player.getQueue()

    this.innerHTML = ''

    this.appendChild(renderTemplate('partials/player-queue', this.ownerDocument, {
      currentTrack: app.player.getCurrentTrack(),
      userQueue: queue.userQueue.tracks,
      playQueue: queue.playQueue.tracks.tracks
    }))
  }
}
