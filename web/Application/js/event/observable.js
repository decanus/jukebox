import _Observable from 'zen-observable'

export class Observable extends _Observable {
  /**
   *
   * @returns {Observable<V>}
   */
  distinct () {
    let lastDistinct

    return this.filter((value) => {
      let distinct = (value !== lastDistinct)

      if (distinct) {
        lastDistinct = value
      }

      return distinct
    })
  }

  /**
   *
   * @returns {Promise<T>}
   */
  once () {
    return new Promise((resolve, reject) => {
      let subscription = this.subscribe({
        next (value) {
          subscription.unsubscribe()
          resolve(value)
        },
        error (error) {
          reject(error)
        },
        complete () {
          reject(new Error('early complete before value'))
        }
      })
    })
  }

  /**
   *
   * @param {number} limit
   * @returns {Observable<V>}
   */
  take (limit) {
    let taken = 0
    let C = this.constructor.species

    return new C((observer) => {
      let subscription = this.subscribe({
        next (value) {
          taken += 1

          observer.next(value)

          if (taken === limit) {
            observer.complete()
            subscription.unsubscribe()
          }
        },
        error: (error) => observer.error(error),
        complete: () => observer.complete()
      })

      return () => subscription.unsubscribe()
    })
  }

  /**
   *
   * @returns {Observable}
   */
  static get [Symbol.species] () {
    return Observable
  }

  /**
   *
   * @param {...Observable} observables
   * @returns {Observable}
   */
  static merge (...observables) {
    let completed = 0

    return new Observable((observer) => {
      let complete = () => {
        completed++

        if (completed === observables.length) {
          observer.complete()
        }
      }

      let subscriptions = observables.map((observable) => {
        return observable.subscribe({
          next: (value) => observer.next(value),
          error: (error) => observer.error(error),
          complete: complete
        })
      })

      return () => {
        subscriptions.forEach((subscription) => subscription.unsubscribe())
      }
    })
  }
}
