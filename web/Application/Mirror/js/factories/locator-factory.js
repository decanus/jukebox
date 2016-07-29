/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { ViewLocator } from '../locators/view-locator'
  
export class LocatorFactory {
  /**
   *
   * @param {MasterFactory} masterFactory
   */
  constructor (masterFactory) {
    this._masterFactory = masterFactory
  }

  /**
   *
   * @returns {Array<string>}
   */
  static get factoryMethods () {
    return [
      'createViewLocator'
    ]
  }

  /**
   * 
   * @returns {ViewLocator}
   */
  createViewLocator () {
    return new ViewLocator(this._masterFactory)
  }
}
