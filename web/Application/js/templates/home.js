/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'

/**
 *
 * @param {Document} doc
 */
export function renderHomeTemplate (doc) {
  const fragment = doc.createDocumentFragment()

  const wrap = createElement(doc, 'div', '', {
    'class': 'page-wrap -padding'
  })

  fragment.appendChild(wrap)

  wrap.appendChild(createElement(doc, 'h1', 'Welcome to Jukebox Ninja'))
  wrap.appendChild(createElement(doc, 'p', 'Music like never before'))

  wrap.appendChild(createElement(doc, 'a', 'Create Playlist', {
    is: 'jukebox-link',
    href: '/playlists/create'
  }))

  wrap.appendChild(createElement(doc, 'br'))

  wrap.appendChild(createElement(doc, 'a', 'Lorem Ipsum', {
    is: 'jukebox-link',
    href: '/lorem'
  }))

  return fragment
}
