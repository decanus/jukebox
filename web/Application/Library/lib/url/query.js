/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { encodeValue, decodeValue } from './value'

/**
 * @param {Array<Array<string>>} params
 * @returns {string}
 */
export function buildQuery (params) {
  return Array.from(params)
    .map((pair) => pair.map(encodeValue).join('='))
    .join('&')
}

/**
 *
 * @param {string} query
 */
export function parseQuery (query) {
  if (query[ 0 ] === '?') {
    query = query.substr(1)
  }

  const pairs = query
    .split('&')
    .filter((str) => str.length !== 0)
    .map((str) => str.split('='))
    .map((pair) => [
      decodeValue(pair[ 0 ]),
      decodeValue(pair[ 1 ] || null)
    ])

  return new Map(pairs)
}
