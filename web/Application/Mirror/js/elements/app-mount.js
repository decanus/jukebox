/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class AppMount extends HTMLElement {
  /**
   *
   * @param {LocationWrapper} locationWrapper
   */
  constructor (locationWrapper) {
    super()

    this._locationWrapper = locationWrapper
    this._onUriChanged = this._onUriChanged.bind(this)
  }

  connectedCallback () {
    this._locationWrapper.onUriChanged.addListener(this._onUriChanged)
    this._onUriChanged(this._locationWrapper.uri)
  }

  disconnectedCallback () {
    this._locationWrapper.onUriChanged.removeListener(this._onUriChanged)
  }

  _onUriChanged (route) {
    console.log(route)

    this.innerHTML = ''
    this.appendChild(<app-view view-name="home"/>)
  }
}
