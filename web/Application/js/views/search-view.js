/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Page } from './page'
import { ViewRepository } from './view-repository'
import { ResultId } from '../value/result-id'

/**
 *
 * @param {string} query
 * @param {Array<string>} includes
 * @returns {View}
 */
export function SearchView ({ query, includes }) {
  query = query.trim()

  return {
    /**
     *
     * @returns {Page}
     */
    async fetch () {
      const result = await app.modelRepository.getResult(new ResultId(query, includes))

      return new Page({ title: 'Jukebox Ninja - Search', template: 'search', data: result })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)
      const models = page.data.results

      repository.hold(page.data)

      models.forEach((model) => {
        repository.hold(model)

        if (model.type === 'tracks') {
          model.artists.forEach((artist) => repository.hold(artist.artist))
        }
      })

      return () => repository.releaseAll()
    }
  }
}
