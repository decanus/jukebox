/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {EventTarget} element
 * @param {string} eventName
 * @returns {Promise<Event>}
 */
export function createPromise (element, eventName) {
  return new Promise((resolve) => {
    let handler = (event) => {
      element.removeEventListener(eventName, handler, true)
      resolve(event)
    }

    element.addEventListener(eventName, handler, true)
  })
}
