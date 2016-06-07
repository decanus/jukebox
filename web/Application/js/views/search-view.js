/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { fetchSearch } from '../apr/apr'
import { app } from '../app'
import { Page } from './page'

export function SearchView(query) {
  return {
    /**
     *
     * @returns {Promise<Page>}
     */
    fetch () {
      const loader = app.getModelLoader()

      return fetchSearch(query)
        .then((results) => {
          return results.map((result) => loader.load(result))
        })
        .then((results) => {
          return new Page({ title: 'Jukebox Ninja - Search', template: 'search', data: { results, query } })
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
