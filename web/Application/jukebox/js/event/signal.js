/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Observable } from './observable'

/**
 *
 * @template T
 * @constructor
 */
export function Signal () {

}

/**
 *
 * @param {(function(value: T))} callbackFn
 */
Signal.prototype.addListener = function (callbackFn) {
  if (this._listeners == null) {
    this._listeners = new Set()
  }

  this._listeners.add(callbackFn)
}

Signal.prototype.removeListener = function (callbackFn) {
  if (this._listeners == null) {
    return
  }

  this._listeners.delete(callbackFn)
}

/**
 *
 * @param {T} [value]
 */
Signal.prototype.dispatch = function (value) {
  this._listeners.forEach((listener) => listener(value))
}

/**
 *
 * @returns {Observable<T>}
 */
Signal.prototype.toObservable = function () {
  return new Observable((observer) => {
    let onValue = (value) => observer.next(value)

    this.addListener(onValue)

    return () => this.removeListener(onValue)
  })
}
