/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { PlaylistPlayer as Player } from '../players/playlist-player'
import { PlayerState } from '../players/player-state'
import { createElement } from '../dom/create-element'
import { formatSeconds } from '../time/format-seconds'

const player = new Player([
  'youtube:jcF5HtGvX5I',
  'deezer:92818806',
  'soundcloud:245692565',
  'soundcloud:244408910',
  'youtube:DQMbHNofCzw',
  'deezer:118204446',
  'deezer:104953416',
  'soundcloud:211719430',
  'deezer:103779780',
  'deezer:99938476',
  'deezer:114394690'
])

function createControlElement (doc, icon) {
  let $control = createElement(doc, 'button', icon, {
    'class': 'control',
    'role': 'button'
  })

  let $icon = createElement(doc, 'span', '', {
    'class': `fa fa-${icon}`
  })

  $control.appendChild($icon)

  return $control
}

export class PlaylistPlayer extends HTMLElement {
  /**
   * @internal
   */
  createdCallback () {
    this.classList.add('audio-player')

    let playerState = PlayerState.STOPPED

    player.getState().forEach((value) => {
      playerState = value
    })

    let trackDuration = 0

    player.getTrack().forEach((track) => {
      trackDuration = track.duration
    })

    let $controls = createElement(this.ownerDocument, 'div', '', {
      'class': 'controls'
    })

    this.appendChild($controls)

    let $prev = $controls.appendChild(createControlElement(this.ownerDocument, 'step-backward'))
    $prev.addEventListener('click', () => player.prev())

    let $play = $controls.appendChild(createControlElement(this.ownerDocument, 'play'))
    $play.classList.add('-larger')

    let $playIcon = $play.querySelector('.fa')

    $play.addEventListener('click', () => {
      switch (playerState) {
        case PlayerState.PLAYING:
          return player.pause()
        case PlayerState.PAUSED:
        case PlayerState.STOPPED:
          return player.play()
      }
    })

    player.getPlay().forEach(() => {
      $playIcon.className = 'fa fa-pause'
    })

    player.getPause().forEach(() => {
      $playIcon.className = 'fa fa-play'
    })

    player.getLoading().forEach(() => {
      console.log('loading')
      $playIcon.className = 'fa fa-cog fa-spin'
    })

    let $next = $controls.appendChild(createControlElement(this.ownerDocument, 'step-forward'))
    $next.addEventListener('click', () => player.next())

    let $time = createElement(this.ownerDocument, 'div', '0:00', {
      'class': 'time'
    })

    player.getPosition().forEach((value) => {
      let [minutes, seconds] = formatSeconds(value)

      $time.textContent = `${minutes}:${seconds}`
    })

    this.appendChild($time)

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

    let $duration = createElement(this.ownerDocument, 'div', '0:00', {
      'class': 'time'
    })

    player.getTrack().forEach((track) => {
      let [minutes, seconds] = formatSeconds(track.duration)

      $duration.textContent = `${minutes}:${seconds}`
    })

    this.appendChild($duration)

    let $artwork = createElement(this.ownerDocument, 'img', '', {
      'class': 'artwork'
    })

    player.getTrack().forEach((track) => {
      $artwork.src = track.artwork

      this.ownerDocument
        .querySelector('#youtube-player-wrap')
        .style.display = track.video ? '' : 'none'
    })

    this.appendChild($artwork)

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

    player.preload()
  }
}
