/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

module.exports.parseFlags = parseFlags

/**
 *
 * @param {Array} argv
 * @returns {Map}
 */
function parseFlags (argv) {
  const flags = argv
    .filter(($) => $.substr(0, 2) === '--')
    .map(($) => $.substr(2))
    .map(($) => $.split('='))

  return new Map(flags)
}
