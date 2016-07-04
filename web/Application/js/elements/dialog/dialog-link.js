/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */
  
window.__$weak = new WeakSet()

export class DialogLink extends HTMLAnchorElement {

  attachedCallback () {
    this.addEventListener('click', (event) => {
      event.preventDefault()
      
      // todo: enable ctrl-click to open in new tab
      
      /** @type {DialogContent} */
      const $content = this.ownerDocument.querySelector(`dialog-content#${this.openDialog}`)

      $content.open()
    })
  }

  /**
   *
   * @returns {string}
   */
  get openDialog () {
    return this.getAttribute('open-dialog')
  }
}
