/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { HomeView } from '../views/home-view'
  
export class ViewFactory {
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
      'createHomeView'
    ]
  }

  /**
   * 
   * @returns {HomeView}
   */
  createHomeView () {
    return new HomeView()
  }
}
