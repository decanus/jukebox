/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { createElement } from '../dom/create-element'

/**
 *
 * @type {string}
 */
const LOREM = 'Williamsburg mustache four dollar toast austin, mumblecore flannel bespoke +1 marfa deep v forage lumbersexual salvia waistcoat. Jean shorts cliche fanny pack selvage. Locavore authentic jean shorts, viral bespoke banjo you probably haven\'t heard of them austin. Ugh ethical kitsch, hella venmo fanny pack mixtape heirloom crucifix craft beer shabby chic quinoa chicharrones waistcoat. Irony migas polaroid ramps, kombucha man bun master cleanse forage craft beer next level scenester pork belly pour-over. Bicycle rights bushwick chicharrones bespoke quinoa, intelligentsia lomo green juice tofu direct trade microdosing. Asymmetrical poutine freegan flannel biodiesel, sriracha marfa helvetica four dollar toast heirloom.'

/**
 *
 * @param {Document} doc
 */
export function renderLoremTemplate (doc) {
  const fragment = doc.createDocumentFragment()
  const wrap = fragment.appendChild(createElement(doc, 'div', '', {
    'class': 'page-wrap -padding'
  }))

  for (let i = 0; i < 10; i++) {
    wrap.appendChild(createElement(doc, 'p', LOREM))
  }

  return fragment
}
