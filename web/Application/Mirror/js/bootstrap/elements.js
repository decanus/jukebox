/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * 
 * @param {MasterFactory|ElementFactory} factory
 */
export function defineElements (factory) {
  customElements.define('socket-debug', factory.createSocketDebugClass())
  customElements.define('app-view', factory.createAppViewClass())
  customElements.define('app-mount', factory.createAppMountClass())
}
