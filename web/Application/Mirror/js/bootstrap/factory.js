/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { MasterFactory } from '../factories/master-factory'
import { WrapperFactory } from '../factories/wrapper-factory'
import { ElementFactory } from '../factories/element-factory'
import { ViewFactory } from '../factories/view-factory'
import { LocatorFactory } from '../factories/locator-factory'

/**
 * 
 * @returns {MasterFactory}
 */
export function buildFactory () {
  const factory = new MasterFactory({ isDevelopmentMode: true })

  factory.registerFactory(WrapperFactory)
  factory.registerFactory(ElementFactory)
  factory.registerFactory(ViewFactory)
  factory.registerFactory(LocatorFactory)

  return factory
}
