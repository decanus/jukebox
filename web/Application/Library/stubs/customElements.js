/**
 * @typedef {{ extends: string }} ElementDefinitionOptions
 */

class CustomElementsRegistry {
  /**
   *
   * @param {string} name
   * @param {*} constructor
   * @param {ElementDefinitionOptions} [options]
   * @returns void
   */
  define (name, constructor, options) {

  }

  /**
   *
   * @param {string} name
   * @returns {Function}
   */
  get (name) {

  }

  /**
   *
   * @param {string} name
   * @returns {Promise<void>}
   */
  whenDefined (name) {
    
  }
}

window.customElements = new CustomElementsRegistry()
