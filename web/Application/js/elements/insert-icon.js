/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class InsertIcon extends HTMLElement {

  createdCallback () {
    this.updateDom()
  }


  attributeChangedCallback() {
    this.updateDom()
  }

  updateDom () {
    //noinspection JSValidateTypes
    if (this.iconName == null || this.iconName === '') {
      return
    }

    this.innerHTML = ''
    
    const svg = this.ownerDocument.createElementNS('http://www.w3.org/2000/svg', 'svg')
    const use = this.ownerDocument.createElementNS('http://www.w3.org/2000/svg', 'use')

    use.setAttributeNS('http://www.w3.org/1999/xlink', 'href', `/images/icons.svg#${this.iconName}`)

    svg.appendChild(use)
    this.appendChild(svg)
  }

  /**
   *
   * @returns {string}
   */
  get iconName () {
    return this.getAttribute('icon-name')
  }

  /**
   * 
   * @param {string} value
   */
  set iconName (value) {
    this.setAttribute('icon-name', value)
  }
}
