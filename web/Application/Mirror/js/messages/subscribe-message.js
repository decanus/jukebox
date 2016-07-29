/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * 
 * @param {string} mirrorId
 * @returns {{type: string, action: string, mirrorId: string}}
 * @constructor
 */
export function SubscribeMessage(mirrorId) {
  return { type: 'action', action: 'subscribe', mirrorId }  
}
