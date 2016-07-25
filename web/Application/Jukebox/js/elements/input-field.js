/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class InputField extends HTMLElement {
  createdCallback () {
    const input = this.querySelector('input')

    input.addEventListener('focus', () => {
      this.focus = true
    })
    
    input.addEventListener('blur', () => {
      this.focus = false
    })
  }

  /**
   *
   * @returns {boolean}
   */
  get focus () {
    return this.classList.contains('-focus')
  }

  /**
   *
   * @param {boolean} value
   */
  set focus (value) {
    if (value) {
      this.classList.add('-focus')
    } else {
      this.classList.remove('-focus')
    }
  }
}
