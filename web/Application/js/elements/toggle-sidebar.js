/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class ToggleSidebar extends HTMLButtonElement {
  createdCallback() {
    console.log('created')
    
    this.addEventListener('click', () => {
      console.log('toggle')
      app.toggleSidebar()
    })
  }
}
