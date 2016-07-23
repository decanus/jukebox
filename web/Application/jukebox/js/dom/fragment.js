/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {HTMLDocument} doc
 * @param {string} string
 *
 * @returns {DocumentFragment}
 */
export function createFragmentFromString(doc, string) {
  const range = doc.createRange()

  range.selectNode(doc.body)

  return range.createContextualFragment(string)
}
