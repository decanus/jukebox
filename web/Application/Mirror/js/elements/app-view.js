/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class AppView extends HTMLElement {
  /**
   *
   * @param {ViewLocator} viewLocator
   */
  constructor (viewLocator) {
    super()

    /**
     *
     * @type {ViewLocator}
     * @private
     */
    this._viewLocator = viewLocator
  }

  connectedCallback () {
    const view = this._viewLocator.locate(this.viewName)

    this.innerHTML = ''

    view.fetchData()
      .then(() => {

        if (this.parentNode == null) {
          return
        }

        view.prepareData()
        
        this.appendChild(view.render())

        this._view = view
      })
  }

  disconnectedCallback () {
    this._view.cleanup()
  }

  /**
   * 
   * @returns {string}
   */
  get viewName () {
    return this.getAttribute('view-name')
  }
}
