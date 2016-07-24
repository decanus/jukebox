/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * 
 * @param {MasterFactory|ElementFactory} factory
 */
export function defineElements (factory) {
  customElements.define('socket-debug', factory.createSocketDebugClass())
}
