/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {Page} page
 * @returns {View}
 */
export function StaticView (page) {
  return {
    fetch () {
      return Promise.resolve(page)
    },
    handle () {
      return () => {}
    }
  }
}
