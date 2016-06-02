/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

export class ToggleSidebar extends HTMLButtonElement {
  createdCallback() {
    this.addEventListener('click', () => {
      app.toggleSidebar()
    })
  }
}
