/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class ArtistProfiles {
  /**
   *
   * @param {number} id
   * @param {Array<ArtistProfile>} profiles
   */
  constructor ({ id, profiles }) {
    this.id = id
    this.profiles = profiles

    Object.freeze(this)
  }

  /**
   *
   * @returns {string}
   */
  get type () {
    return 'artist-profiles'
  }
}
