/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Observable } from '../../event/observable'

/**
 *
 * @param {number} interval
 * @returns {Observable}
 */
export function getInterval (interval) {
  return new Observable((observer) => {
    let handler = () => observer.next()
    let id = window.setInterval(handler, interval)

    return () => {
      window.clearInterval(id)
    }
  })
}
