/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Observable } from './observable'

/**
 *
 * @type {Symbol}
 */
const events = Symbol('events')

/**
 * @deprecated Use Signals instead
 */
export class Emitter {
  constructor () {
    /**
     *
     * @type {Map}
     */
    this[ events ] = new Map()
  }

  /**
   *
   * @param {string} name
   * @param {Function} callbackFn
   * @deprecated
   */
  on (name, callbackFn) {
    let listeners = this[ events ].get(name)

    if (!listeners) {
      listeners = new Set()
      this[ events ].set(name, listeners)
    }

    listeners.add(callbackFn)
  }

  /**
   *
   * @param {string} name
   * @param {Function} callbackFn
   * @deprecated
   */
  off (name, callbackFn) {
    if (!this[ events ].get(name)) {
      return
    }

    this[ events ].get(name).delete(callbackFn)
  }

  /**
   *
   * @param {string} name
   * @param {*} [data]
   */
  emit (name, data) {
    if (!this[ events ].get(name)) {
      return
    }

    this[ events ].get(name).forEach((fn) => fn(data))
  }

  /**
   *
   * @param {string} name
   * @param {Function} callbackFn
   * @returns {function()}
   */
  addListener (name, callbackFn) {
    this.on(name, callbackFn)

    return () => {
      this.off(name, callbackFn)
    }
  }

  /**
   *
   * @param {Emitter} emitter
   * @param {string} eventName
   *
   * @returns {Observable}
   * @deprecated
   */
  static toObservable (emitter, eventName) {
    return new Observable((observer) => {
      let handler = (value) => observer.next(value)

      emitter.on(eventName, handler)

      return () => emitter.off(eventName, handler)
    })
  }

  /**
   * 
   * @param {string} eventName
   * @returns {Observable}
   */
  toObservable(eventName) {
    return Emitter.toObservable(this, eventName)
  }
}
