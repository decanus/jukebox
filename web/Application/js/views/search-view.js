/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../apr/apr'
import { app } from '../app'
import { Page } from './page'

/**
 *
 * @param {string} query
 * @returns {View}
 */
export function SearchView (query) {
  const store = app.getModelStore()

  query = query.trim()

  return {
    /**
     *
     * @returns {Promise<Page>}
     */
    fetch () {
      const loader = app.getModelLoader()
      const key = { id: query, type: 'results' }
      let results

      if (store.has(key)) {
        results = Promise.resolve(store.get(key))
      } else {
        //noinspection JSCheckFunctionSignatures
        results = fetchSearch(query)
          .then((results) => loader.loadResult({ id: query, ...results }))
      }

      return results
        .then((result) => {
          return new Page({ title: 'Jukebox Ninja - Search', template: 'search', data: result })
        })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const store = app.getModelStore()
      const models = page.data.results

      store.hold(page.data)

      models.forEach((model) => {
        store.hold(model)

        if (model.type === 'tracks') {
          model.artists.forEach((artist) => store.hold(artist.artist))
        }
      })

      return () => {
        store.release(page.data)

        models.forEach((model) => {
          store.release(model)

          if (model.type === 'tracks') {
            model.artists.forEach((artist) => store.release(artist.artist))
          }
        })
      }
    }
  }
}
