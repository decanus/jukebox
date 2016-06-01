/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlayerState } from '../players/player-state'
import { createElement } from '../dom/create-element'
import { formatSeconds } from '../time/format-seconds'
import { player } from '../player'

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

// TODO: rename this and the custom tag to player-controls
export class PlaylistPlayer extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.classList.add('player-controls')

    let playerState = PlayerState.STOPPED

    let trackDuration = 0

    player.getTrack().forEach((track) => {
      trackDuration = track.duration
    })

    let $position = createElement(this.ownerDocument, 'div', '', {
      'class': 'position'
    })

    $position.addEventListener('click', (e) => {
      if (playerState !== PlayerState.PLAYING) {
        return
      }

      let box = $position.getBoundingClientRect()
      let position = e.clientX - box.left

      player.setPosition(position / box.width * trackDuration)
    })

    this.appendChild($position)

    let $inner = createElement(this.ownerDocument, 'div', '', {
      'class': 'inner'
    })

    let $handle = createElement(this.ownerDocument, 'div', '', {
      'class': 'handle'
    })

    player.getPosition().forEach((value) => {
      let pos = (100 / trackDuration * value) + '%'

      $inner.style.width = pos
      $handle.style.left = pos
    })

    $position.appendChild($inner)
    $position.appendChild($handle)
    
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

    let $time = createElement(this.ownerDocument, 'div', '0:00', {
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

    this.appendChild($duration)
    
    let $track = createElement(this.ownerDocument, 'div', '', {
      'class': 'track'
    })

    this.appendChild($track)

    let $service = createElement(this.ownerDocument, 'div', '', {
      'class': 'service'
    })

    player.getTrack().forEach((track) => {
      $service.innerText = `playing from ${track.service}`
    })

    $track.appendChild($service)

    let $name = createElement(this.ownerDocument, 'div', '', {
      'class': 'name'
    })

    player.getTrack().forEach((track) => {
      $name.innerText = `${track.title}`
    })

    $track.appendChild($name)

    player.getState().forEach((value) => {
      playerState = value

      if (playerState === PlayerState.PLAYING) {
        $playIcon.src = '/images/icons/pause.svg'
        return
      }

      $playIcon.src =  '/images/icons/play.svg'
    })

    player.preload()
  }
}
