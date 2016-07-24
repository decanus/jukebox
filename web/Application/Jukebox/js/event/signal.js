/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { Observable } from './observable'
import { Signal as _Signal } from '../library/event/signal'

export class Signal extends _Signal {
  toObservable () {
    return new Observable((observer) => {
      let onValue = (value) => observer.next(value)

      this.addListener(onValue)

      return () => this.removeListener(onValue)
    })
  }
}
