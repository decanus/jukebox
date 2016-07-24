/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { MasterFactory } from '../factory/master-factory'
import { AppFactory } from '../factory/app-factory'
import { ElementFactory } from '../factory/element-factory'

/**
 * 
 * @returns {MasterFactory}
 */
export function buildFactory () {
  const factory = new MasterFactory({ isDevelopmentMode: true })

  factory.registerFactory(AppFactory)
  factory.registerFactory(ElementFactory)
  
  return factory
}
