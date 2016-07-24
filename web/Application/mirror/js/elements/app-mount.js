/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class AppMount extends HTMLElement {

  constructor () {
    super()
    
    this.textContent = 'Hello World'
  }

  connectedCallback () {
  
  }

  disconnectedCallback () {

  }

}
