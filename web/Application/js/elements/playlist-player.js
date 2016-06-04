/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlayerState } from '../players/player-state'
import { createElement } from '../dom/create-element'
import { formatSeconds } from '../time/format-seconds'
import { app } from '../app'
import { ScrobbleBar } from '../elements'

/**
 * 
 * @type {PlayerDelegate}
 */
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

  let $icon = createElement(doc, 'img', '', {
    'src': `/images/icons/${icon}.svg`
  })

  $control.appendChild($icon)

  return $control
}

export class PlaylistPlayer extends HTMLElement {
  createdCallback() {
    this.classList.add('player-controls')

    let playerState = PlayerState.STOPPED

    /**
     * 
     * @type {Element}
     */
    let $position = new ScrobbleBar()

    player.getDuration().forEach((duration) => {
      $position.setTotal(duration)
    })

    player.getTrack().forEach(() => {
      $position.reset()
    })
    
    player.getPosition().forEach((value) => ($position.setValue(value)))

    $position.addEventListener('change', (event) => {
      if (playerState !== PlayerState.PLAYING) {
        return
      }

      player.setPosition(event.detail.value)
    })
    
    this.appendChild($position)

    let $controls = createElement(this.ownerDocument, 'div', '', {
      'class': 'controls'
    })

    this.appendChild($controls)

    let $prev = $controls.appendChild(createControlElement(this.ownerDocument, 'previous'))
    $prev.addEventListener('click', () => player.prev())
    $prev.classList.add('-prev')

    let $play = $controls.appendChild(createControlElement(this.ownerDocument, 'play'))
    $play.classList.add('-playpause')

    let $playIcon = $play.querySelector('img')

    $play.addEventListener('click', () => {
      switch (playerState) {
        case PlayerState.PLAYING:
          return player.pause()
        case PlayerState.PAUSED:
        case PlayerState.STOPPED:
          return player.play()
      }
    })

    let $next = $controls.appendChild(createControlElement(this.ownerDocument, 'next'))
    $next.addEventListener('click', () => player.next())
    $next.classList.add('-next')

    /*let $time = createElement(this.ownerDocument, 'div', '0:00', {
      'class': 'time'
    })

    player.getPosition().forEach((value) => {
      let [minutes, seconds] = formatSeconds(value)

      $time.textContent = `${minutes}:${seconds}`
    })

    this.appendChild($time)



    let $duration = createElement(this.ownerDocument, 'div', '0:00', {
      'class': 'time'
    })

    player.getTrack().forEach((track) => {
      let [minutes, seconds] = formatSeconds(track.duration)

      $duration.textContent = `${minutes}:${seconds}`
    })

    this.appendChild($duration)*/

    player.getState().forEach((value) => {
      playerState = value

      if (playerState === PlayerState.PLAYING) {
        $playIcon.src = '/images/icons/pause.svg'
        return
      }

      $playIcon.src =  '/images/icons/play.svg'
    })
  }
}
