/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */
  
import { ScrobbleBar } from '../elements/scrobble-bar'

export class CustomElementFactory {
  /**
   *
   * @param {Application} application
   */
  constructor(application) {
    this.application = application

    Object.freeze(this)
  }

  /**
   *
   * @param {HTMLElement} $
   * @returns {ScrobbleBar}
   */
  createScrobbleBar($) {
    return new ScrobbleBar($)
  }
}
