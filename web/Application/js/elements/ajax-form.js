/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class AjaxForm extends HTMLFormElement {
  attachedCallback () {
    this.addEventListener('submit', async (event) => {
      event.preventDefault()
      
      const response = await fetch(this.action, {
        method: 'POST',
        mode: 'same-origin',
        credentials: 'same-origin'
      })
      
      const data = await response.json()
      
      console.log(data)
    })
  }
}
