/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Track } from '../value/track'

/**
 * 
 * @param {number} trackId
 * @returns {Promise<Track>}
 */
export function fetchTrack(trackId) {
  // TODO: fetch this from the server
  switch(trackId) {
    case 0:
      return Promise.resolve(new Track(0, 'Faded - Alan Walker', { youtubeId: '60ItHLz5WEA' }))
    case 149:
      return Promise.resolve(new Track(149, 'Cheap Thrills', { youtubeId: 'J1b22l1kFKY' }))
    case 170:
      return Promise.resolve(new Track(170, 'Someone Like You', { youtubeId: 'hLQl3WQQoQ0' }))
    case 1:
      return Promise.resolve(new Track(1, 'The Night Is Still Young', { youtubeId: 'IvN5h9BE444' }))
  }
}
