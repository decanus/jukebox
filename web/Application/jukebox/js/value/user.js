/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class User {
  /**
   * 
   * @param {string} username
   * @param {string} email
   */
  constructor (username, email) {
    this.username = username
    this.email = email

    Object.freeze(this)
  }
}
