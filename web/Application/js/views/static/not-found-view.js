/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Page } from '../page'
import { StaticView } from '../static-view'

/**
 *
 * @returns {View}
 */
export const NotFoundView = ({ uri }) => StaticView(new Page({ title: 'Jukebox Ninja - Page Not Found', template: '404', data: { uri } }))
