/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @typedef {{ isDevelopmentMode: boolean }} Configuration
 */

export class MasterFactory {
  /**
   *
   * @param {Configuration} config
   */
  constructor (config) {
    //noinspection JSUnresolvedVariable
    this._config = config
  }

  /**
   *
   * @param {Function} Factory
   */
  registerFactory (Factory) {
    const factory = new Factory(this)

    //noinspection JSUnresolvedVariable
    Factory.factoryMethods
      .forEach((method) => {
        //noinspection JSUnresolvedVariable
        Object.defineProperty(this, method, {
          value: Factory.prototype[ method ].bind(factory)
        })
      })
  }
}
