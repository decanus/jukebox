/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../apr/apr'
import { app } from '../app'
import { Page } from './page'

export function SearchView(query) {
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

      models.forEach((model) => {
        store.hold(model)
        
        if (model.type === 'tracks') {
          store.hold(model.artist)
        }
      })

      return () => {
        models.forEach((model) => {
          store.release(model)

          if (model.type === 'tracks') {
            store.release(model.artist)
          }
        })
      }
    }
  }
}
