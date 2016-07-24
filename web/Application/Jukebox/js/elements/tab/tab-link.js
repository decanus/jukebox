/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class TabLink extends HTMLElement {
  createdCallback () {
    this.addEventListener('click', () => {
      const tabs = Array.from(this.ownerDocument.querySelectorAll(`tab-content[tab-group="${this.tabGroup}"]`))

      if (tabs.length === 0) {
        console.warn(`no tabs found with group '${this.tabGroup}'`)
      }

      tabs.forEach((tab) => (tab.hidden = true))

      tabs
        .filter((tab) => tab.tabName === this.tabName)
        .forEach((tab) => (tab.hidden = false))

      const tabLinks = Array.from(this.ownerDocument.querySelectorAll(`tab-link[tab-group="${this.tabGroup}"]`))

      tabLinks.forEach((link) => link.removeAttribute('active'))
      this.setAttribute('active', '')
    })
  }

  /**
   *
   * @returns {string}
   */
  get tabName () {
    return this.getAttribute('tab-name')
  }

  /**
   *
   * @returns {string}
   */
  get tabGroup () {
    return this.getAttribute('tab-group')
  }
}
