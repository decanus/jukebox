/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @template T
 * @param {Array<T>} array
 * @param {T} element
 * @returns {Array<T>}
 */
export function removeElement(array, element) {
  const index = array.indexOf(element)
  const newArray = Array.from(array)

  if (index === -1) {
    return newArray
  }

  return newArray.splice(index, 1)
}
