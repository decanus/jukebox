/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { MasterFactory } from '../factory/master-factory'
import { AppFactory } from '../factory/app-factory'
import { ElementFactory } from '../factory/element-factory'
import { ViewFactory } from '../factory/view-factory'
import { LocatorFactory } from '../factory/locator-factory'

/**
 * 
 * @returns {MasterFactory}
 */
export function buildFactory () {
  const factory = new MasterFactory({ isDevelopmentMode: true })

  factory.registerFactory(AppFactory)
  factory.registerFactory(ElementFactory)
  factory.registerFactory(ViewFactory)
  factory.registerFactory(LocatorFactory)

  return factory
}
