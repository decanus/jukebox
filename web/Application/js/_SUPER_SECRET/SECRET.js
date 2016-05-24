import { player } from '../player'
import { Track } from '../track/track'

/**
 * 
 * @type {Track}
 */
const track = new Track(
  666, 
  atob('TmV2ZXIgR29ubmEgR2l2ZSBZb3UgVXA='),
  atob('UmljayBBc3RsZXk='),
  { youtubeId: 'dQw4w9WgXcQ', duration: 212 }
)

Object.defineProperty(window, '_SUPER_SECRET_DO_NOT_TOUCH', {
  get() {
    player.playTrack(track)
      .then(() => player.pause())
      .then(() => player.setPosition(85))
      .then(() => player.play())
  }
})
