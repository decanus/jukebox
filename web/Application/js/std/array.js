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

/**
 * @template T
 * @param {Array<T>} array
 * @returns {Array<T>}
 */
export function shuffleArray(array) {
  let newArray = Array.from(array)
  let m = array.length, t, i

  while (m) {
    i = Math.floor(Math.random() * m--)

    t = newArray[m]
    newArray[m] = newArray[i]
    newArray[i] = t
  }

  return newArray
}
