/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class InsertIcon extends HTMLElement {

  createdCallback () {
    this.innerHTML = ''
    
    const svg = this.ownerDocument.createElementNS('http://www.w3.org/2000/svg', 'svg')
    const use = this.ownerDocument.createElementNS('http://www.w3.org/2000/svg', 'use')

    svg.appendChild(use)
    this.appendChild(svg)

    this._use = use

    this.updateDom()
  }

  attributeChangedCallback() {
    this.updateDom()
  }

  updateDom () {
    this._use.setAttributeNS('http://www.w3.org/1999/xlink', 'href', `/images/icons.svg#${this.iconName}`)
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
