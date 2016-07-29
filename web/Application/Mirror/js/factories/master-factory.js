/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * @typedef {{ isDevelopmentMode: boolean }} Configuration
 */

/**
 * @typedef {Function} ChildFactory
 * @property {Array<String>} factoryMethods
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
   * @param {ChildFactory} Factory
   */
  registerFactory (Factory) {
    const factory = new Factory(this)

    Factory.factoryMethods
      .forEach((method) => {
        Reflect.defineProperty(this, method, {
          value: factory[ method ].bind(factory)
        })
      })
  }
}
