/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { StorageWrapper } from '../dom/storage'
import { app } from '../app'

const storage = new StorageWrapper(window.localStorage)

let volume = storage.get('player-volume')

if (typeof volume !== 'number' || volume < 0 || volume > 100) {
  volume = 100
}

app.player.setVolume(volume)
app.player.getVolume().forEach((volume) => {
  storage.set('player-volume', volume)
})
