/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'

/**
 *
 * @param {Document} doc
 * @param {{path:string}} data
 */
export function renderPageNotFoundTemplate (doc, data) {
  const fragment = doc.createDocumentFragment()

  const wrap = createElement(doc, 'div', '', {
    'class': 'page-wrap -padding'
  })

  fragment.appendChild(wrap)

  wrap.appendChild(createElement(doc, 'h1', 'Page Not Found'))
  wrap.appendChild(createElement(doc, 'p', `Could not locate page ${data.uri}`))
  wrap.appendChild(createElement(doc, 'a', 'Back To Home', {
    href: '/',
    is: 'jukebox-link'
  }))

  return fragment
}
