/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class JukeboxLink extends HTMLAnchorElement {
  /**
   * @internal
   */
  createdCallback () {
    this.addEventListener('click', (e) => {
      e.preventDefault()

      let $app = this.ownerDocument.querySelector('jukebox-app')
      
      if ($app == null) {
        window.location = this.pathname
        return
      }

      $app.route = this.pathname
    })
  }
}
