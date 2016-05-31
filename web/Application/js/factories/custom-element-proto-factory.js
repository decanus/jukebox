/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class CustomElementProtoFactory {
  /**
   *
   * @param {CustomElementFactory} factory
   */
  constructor(factory) {
    this.factory = factory
    this.instances = new WeakMap()
  }

  /**
   * 
   * @returns {HTMLElement}
   */
  createScrobbleBar() {
    return this._makeWrapper(($) => this.factory.createScrobbleBar($))
  }

  /**
   *
   * @param {(function(HTMLElement))} makeInstance
   * @returns {HTMLElement}
   * @private
   */
  _makeWrapper(makeInstance) {
    const Wrapper = Object.create(HTMLElement.prototype)
    const factory = this

    Wrapper.createdCallback = function () {
      const instance = makeInstance(this)
      
      instance.initDom()
      instance.updateDom()
      
      factory.instances.set(this, instance)
    }
    
    return Wrapper
  }

  /**
   *
   * @param {HTMLElement} $
   * @returns {*}
   */
  unwrap($) {
    return this.instances.get($)
  }
}
