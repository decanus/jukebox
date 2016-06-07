/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
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
