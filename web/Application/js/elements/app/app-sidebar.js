/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Detabinator } from '../../dom/detabinator'
import { RenderingStatus } from '../../dom/rendering'

export class AppSidebar extends HTMLElement {
  createdCallback () {
    /**
     *
     * @type {Detabinator}
     * @private
     */
    this._detabinator = new Detabinator(this)
  }

  attachedCallback () {
    RenderingStatus.afterNextRender(() => {
      this._updateInertState()
    })
  }

  /**
   *
   * @returns {boolean}
   */
  get isVisible () {
    return this._body.classList.contains('-sidebar-visible')
  }

  show () {
    this._body.classList.add('-sidebar-visible')
    this._updateInertState()
  }

  hide () {
    this._body.classList.remove('-sidebar-visible')
    this._updateInertState()
  }

  toggle () {
    this._body.classList.toggle('-sidebar-visible')
    this._updateInertState()
  }

  /**
   *
   * @private
   */
  _updateInertState () {
    this._detabinator.inert = !this.isVisible
  }

  /**
   *
   * @returns {HTMLBodyElement}
   * @private
   */
  get _body () {
    return this.ownerDocument.body
  }
}
