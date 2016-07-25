/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { Page } from './page'
import { ViewRepository } from './view-repository'
import { ResultId } from '../value/result-id'
import { encodeValue } from '../library/url/value'

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
      const encodedQuery = encodeValue(query)

      const filters = [
        {
          name: 'Everything',
          type: 'everything',
          icon: 'search',
          active: includes.length === 0 || includes.indexOf('everything') !== -1
        },
        {
          name: 'Tracks',
          type: 'tracks',
          icon: 'disc',
          active: includes.indexOf('tracks') !== -1
        },
        {
          name: 'Artists',
          type: 'artists',
          icon: 'person',
          active: includes.indexOf('artists') !== -1
        }
      ]

      return new Page({
        title: 'Jukebox Ninja - Search', template: 'search', data: {
          result,
          encodedQuery,
          filters
        }
      })
    },
    /**
     *
     * @param {Page} page
     * @returns {function()}
     */
    handle (page) {
      const repository = new ViewRepository(app.modelRepository)
      const models = page.data.result.results

      repository.hold(page.data.result)

      models.forEach((model) => {
        repository.hold(model)

        if (model.type === 'tracks') {
          model.artists.forEach((artist) => repository.hold(artist.artist))
        }

        if (model.type === 'artists') {
          repository.hold(model.image)
        }
      })

      return () => repository.releaseAll()
    }
  }
}
