/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class AppMount extends HTMLElement {
  constructor () {
    super()
  }

  connectedCallback () {
    this.appendChild(<app-view view-name="home" />)
  }

  disconnectedCallback () {
    
  }
}
