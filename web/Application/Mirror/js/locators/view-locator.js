/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ViewLocator {
  /**
   *
   * @param {MasterFactory|ViewFactory} factory
   */
  constructor (factory) {
    this._factory = factory
  }

  /**
   *
   * @param name
   * @returns {View}
   */
  locate (name) {
    switch (name) {
      case 'home':
        //noinspection JSValidateTypes
        return this._factory.createHomeView()
    }

    throw new Error(`could not locate view for name ${name}`)
  }
}
