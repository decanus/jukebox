/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class Time {
  /**
   *
   * @param {number} value
   */
  constructor (value) {
    this.value = value
  }

  /**
   * 
   * @returns {string}
   */
  toString () {
    let minutes = Math.floor(this.value / 60)
    let seconds = Math.round(this.value - minutes * 60)

    if (seconds < 10) {
      seconds = `0${seconds}`
    }

    return `${minutes}:${seconds}`
  }
}
