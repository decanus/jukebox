/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../../app'
import { createElement } from '../../dom/create-element'
import { PlayerState } from '../../players/player-state'

const player = app.getPlayer()

/**
 *
 * @param {Document} doc
 * @param {string} icon
 * @returns {Element}
 */
function createControlElement (doc, icon) {
  let $control = createElement(doc, 'div', '', {
    'class': 'control',
    'role': 'button'
  })

  let $icon = createElement(doc, 'insert-icon', '', {
    'icon-name': `${icon}`,
    'class': '-normal'
  })

  $control.appendChild($icon)

  return $control
}

export class PlayerControls extends HTMLElement {
  
  createdCallback() {
    let playerState = PlayerState.STOPPED

    const $controls = createElement(this.ownerDocument, 'div', '', {
      'class': 'player-controls'
    })

    this.appendChild($controls)

    const $prev = $controls.appendChild(createControlElement(this.ownerDocument, 'prev'))
    $prev.addEventListener('click', () => player.prev())
    $prev.classList.add('-prev')

    const $play = $controls.appendChild(createControlElement(this.ownerDocument, 'play'))
    $play.classList.add('-playpause')

    const $playIcon = $play.querySelector('insert-icon')

    $play.addEventListener('click', () => {
      switch (playerState) {
        case PlayerState.PLAYING:
        case PlayerState.LOADING:
          return player.pause()
        case PlayerState.PAUSED:
        case PlayerState.STOPPED:
          return player.play()
      }
    })

    const $next = $controls.appendChild(createControlElement(this.ownerDocument, 'next'))
    $next.addEventListener('click', () => player.next())
    $next.classList.add('-next')

    player.getState().forEach((value) => {
      playerState = value
      
      if (playerState === PlayerState.PLAYING || playerState === PlayerState.LOADING) {
        $playIcon.iconName = 'pause'
        return
      }

      $playIcon.iconName = 'play'
    })
  }
}
