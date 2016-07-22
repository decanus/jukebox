/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { LoginFormHandler } from './handlers/login-form-handler'

/**
 *
 * @param {string} name
 */
export function locateHandler (name) {
  switch (name) {
    case 'login':
      return LoginFormHandler
  }
}
