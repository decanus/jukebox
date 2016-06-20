/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @param {(function(value: T))} executor
 * @template T
 * @constructor
 */
export function EventMaker (executor) {
  const listeners = new Set()

  const cleanup = executor((value) => {
    listeners.forEach((listener) => listener(value))
  })

  this.subscribe = (listener) => {
    listeners.add(listener)

    return () => listeners.delete(listener)
  }

  this.destroy = () => {
    listeners.clear()
    cleanup()
  }

  Object.freeze(this)
}

/**
 *
 * @param {EventMaker<T>} maker
 * @param {(function(T))} filterFn
 * @returns {EventMaker<T>}
 */
EventMaker.filter = function (maker, filterFn) {
  return new EventMaker((push) => {
    return maker.subscribe((value) => {
      if (!filterFn(value)) {
        return
      }

      push(value)
    })
  })
}
