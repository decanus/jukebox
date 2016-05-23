/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {Document} doc
 * @returns {Promise<DocumentFragment>}
 */
export function renderHomeTemplate (doc) {
  return fetch('/html/homepage.html')
    .then((response) => response.text())
    .then((text) => {
      const range = doc.createRange()

      range.selectNode(doc.body)

      return range.createContextualFragment(text)
    })
}
