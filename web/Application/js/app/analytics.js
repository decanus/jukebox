/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import * as config from '../../data/config.json'

/**
 * @type {(function(string, string, ...))}
 */
const ga = window.ga

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

/**
 *
 * @param {Error} error
 */
export function sendException (error) {
  if (config['isDevelopmentMode']) {
    console.error(error)
    return
  }

  ga('send', 'exception', {
    exDescription: getErrorDescription(error),
    exFatal: false
  })
}

/**
 *
 * @param {Route} route
 */
export function trackPageView (route) {
  if (config['isDevelopmentMode']) {
    return
  }

  ga('set', 'page', route.toString())
  ga('send', 'pageview')
}
