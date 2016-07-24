/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { DialogContent, AppView } from '../../app/elements'

export class DialogViewLink extends HTMLAnchorElement {
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

    const dialog = new DialogContent()
    const view = new AppView()

    view.name = this.viewName
    view.data = this.viewData

    dialog.appendChild(view)

    dialog.addEventListener('close', () => {
      dialog.parentNode.removeChild(dialog)
    })

    this.ownerDocument.body.appendChild(dialog)
    
    dialog.open()
  }

  /**
   *
   * @returns {string}
   */
  get viewName () {
    return this.getAttribute('view-name')
  }

  /**
   *
   * @returns {{}|null}
   */
  get viewData () {
    try {
      return JSON.parse(this.getAttribute('view-data'))
    } catch (ignored) {
      return null
    }
  }
}
