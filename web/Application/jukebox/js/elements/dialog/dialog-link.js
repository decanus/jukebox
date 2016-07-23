/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class DialogLink extends HTMLAnchorElement {
  createdCallback () {
    this._onClick = this._onClick.bind(this)
  }

  attachedCallback () {
    this.addEventListener('click', this._onClick)
  }

  detachedCallback () {
    this.removeEventListener('click', this._onClick)
  }

  /**
   *
   * @param {MouseEvent} event
   * @private
   */
  _onClick (event) {
    if (event.ctrlKey || event.metaKey) {
      return true
    }

    event.preventDefault()

    //noinspection JSValidateTypes
    /** @type {DialogContent} */
    const $content = this.ownerDocument.querySelector(`dialog-content#${this.openDialog}`)

    $content.open()
  }

  /**
   *
   * @returns {string}
   */
  get openDialog () {
    return this.getAttribute('open-dialog')
  }
}
