/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from './page'
import { StaticView } from './static-view'

/**
 *
 * @returns {View}
 */
export const LoginView = () => StaticView(new Page({ title: 'Jukebox Ninja - Login', template: 'login' }))
