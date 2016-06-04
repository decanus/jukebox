/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Track } from './track'
import { YoutubeTrack } from './youtube-track'

/**
 * 
 * @param {number} trackId
 * @returns {Promise<Track>}
 */
export function fetchTrack(trackId) {
  // TODO: fetch this from the server
  switch(trackId) {
    case 0:
      return Promise.resolve(
        new Track(0, 'Faded', 'Alan Walker', {
          youtubeTrack: new YoutubeTrack('60ItHLz5WEA', 212.481)
        })
      )
    case 1:
      return Promise.resolve(
        new Track(1, 'Yoncé', 'Beyoncé', {
          youtubeTrack: new YoutubeTrack('jcF5HtGvX5I', 122.841)
        })
      )
    case 2:
      return Promise.resolve(
        new Track(2, 'The Night Is Still Young', 'Nicki Minaj', {
          youtubeTrack: new YoutubeTrack('IvN5h9BE444', 246.841)
        })
      )
  }
}
