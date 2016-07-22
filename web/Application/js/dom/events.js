/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export const Events = {
  /**
   * @const
   */
  VIEW_EXIT_EVENT: 'jnViewExit',
  
  /**
   *
   * @param {EventTarget} target
   * @param {Route} redirectRoute
   */
  dispatchViewExit (target, redirectRoute) {
    const detail = { redirectRoute }

    target.dispatchEvent(new CustomEvent(this.VIEW_EXIT_EVENT, { detail, bubbles: true, cancellable: true }))
  }
}
