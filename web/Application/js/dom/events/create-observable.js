/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Observable } from '../../observable'

/**
 *
 * @param {EventTarget} element
 * @param {string} eventName
 * @returns {Observable<Event>}
 */
export function createObservable (element, eventName) {
  return new Observable((observer) => {
    let handler = (event) => observer.next(event)

    element.addEventListener(eventName, handler, true)

    return () => element.removeEventListener(eventName, handler, true)
  })
}
