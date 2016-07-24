/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from '../page'
import { StaticView } from '../static-view'

/**
 *
 * @returns {View}
 */
export const RegisterView = () => StaticView(new Page({ title: 'Jukebox Ninja - Register', template: 'register' }))
