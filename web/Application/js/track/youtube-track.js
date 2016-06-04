/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class YoutubeTrack {
  /**
   * 
   * @param {string} youtubeId
   * @param {number} duration
   */
  constructor(youtubeId, duration) {
    this.youtubeId = youtubeId
    this.duration = duration
    
    Object.freeze(this)
  }
}
