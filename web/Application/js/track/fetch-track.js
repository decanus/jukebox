/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Track } from './track'

/**
 * 
 * @param {number} trackId
 * @returns {Promise<Track>}
 */
export function fetchTrack(trackId) {
  // TODO: fetch this from the server
  switch(trackId) {
    case 0:
      return Promise.resolve(new Track(0, 'Faded', 'Alan Walker', { youtubeId: '60ItHLz5WEA' }))
    case 1:
      return Promise.resolve(new Track(149, 'Yoncé', 'Beyoncé', { youtubeId: 'jcF5HtGvX5I' }))
    case 2:
      return Promise.resolve(new Track(1, 'The Night Is Still Young', 'Nicki Minaj', { youtubeId: 'IvN5h9BE444' }))
  }
}
