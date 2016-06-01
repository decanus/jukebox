/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class JukeboxLink extends HTMLAnchorElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', (e) => {
      if (e.ctrlKey || e.metaKey) {
        return
      }
      
      e.preventDefault()

      let $app = this.ownerDocument.querySelector('jukebox-app')
      
      $app.route = this.pathname
    })
  }
}
