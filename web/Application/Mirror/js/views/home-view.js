/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { View } from './view'

export class HomeView extends View {
  /**
   * 
   * @returns {XML}
   */
  render () {
    return (
      <div>
        <h1>Mirror</h1>
        <socket-debug />
      </div>
    )
  }
}
