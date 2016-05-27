/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class JukeboxLink extends HTMLAnchorElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', (event) => {
      if (event.ctrlKey || event.metaKey) {
        return
      }

      event.preventDefault()

      let $app = this.ownerDocument.querySelector('jukebox-app')
      
      $app.route = this.pathname
    })
  }
}
