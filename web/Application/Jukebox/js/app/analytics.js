/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {Error} error
 * @returns {string}
 */
function getErrorDescription(error) {
  const string = error.toString()
  const stack = error.stack

  if (stack === undefined) {
    return string
  }

  // chrome puts the error into the stack, safari & firefox don't
  if (stack.indexOf(string) === 0) {
    return stack
  }

  return `${string}\n${stack}`
}

export class Analytics {
  /**
   *
   * @param {UniversalAnalytics.ga} ga
   * @param {{ isDevelopmentMode: true }} config
   */
  constructor (ga, config) {
    this._ga = ga
    this._config = config
  }

  /**
   *
   * @param {Error} error
   */
  sendException (error) {
    if (this._config.isDevelopmentMode) {
      console.error(getErrorDescription(error))
      return
    }

    this._ga('send', 'exception', {
      exDescription: getErrorDescription(error),
      exFatal: false
    })
  }

  /**
   *
   * @param {Uri} route
   */
  trackPageView (route) {
    if (this._config.isDevelopmentMode) {
      return
    }

    this._ga('set', 'page', route.toString())
    this._ga('send', 'pageview')
  }

  /**
   *
   * @param {Track} track
   */
  sendPlayTrack (track) {
    if (this._config.isDevelopmentMode) {
      return
    }

    this._ga('send', {
      hitType: 'event',
      eventCategory: 'Track',
      eventAction: 'play',
      eventLabel: track.title,
      eventValue: track.id
    })
  }

  /**
   * 
   * @param {PlayerDelegator} player
   */
  registerTrackListener (player) {
    player.getTrack()
      .forEach(this.sendPlayTrack.bind(this))
  }
}
