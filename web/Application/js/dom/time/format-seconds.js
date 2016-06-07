/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {number} value
 * @returns {Array<string|number>}
 */
export function formatSeconds (value) {
  let minutes = Math.floor(value / 60)
  let seconds = Math.round(value - minutes * 60)

  if (seconds < 10) {
    seconds = `0${seconds}`
  }

  return [ minutes, seconds ]
}
