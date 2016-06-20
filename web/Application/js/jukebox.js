/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import 'whatwg-fetch'

import { app } from './app'
import { getInterval } from './dom/time/get-interval'
import { Route } from './app/route'
import { trackPageView, sendPlayTrack } from './app/analytics'
import config from '../data/config.json'

import './app/elements'
import './app/media-keys'
import './app/settings'
import { PlayerState } from './players/player-state'

window.addEventListener('popstate', () => {
  app.setRoute(Route.fromLocation(window.location))
})

document.addEventListener('DOMContentLoaded', () => {
  // todo: make listeners use getCurrentRoute() the first time and remove this
  app.setRoute(Route.fromLocation(window.location))

  app.getRoute().forEach(trackPageView)
})

app.player
  .getTrack()
  .forEach((track) => sendPlayTrack(track))

window.__$loadModel = function (model) {
  app.modelRepository.add(model)
}

// todo: figure out an optimal interval for cleanup
getInterval(180000)
  .forEach(() => {
    console.info('it\'s time to clean')
    app.modelRepository.cleanup()
  })

//noinspection JSUnresolvedVariable
if (config.isDevelopmentMode === true) {
  window.__$app = app
}

// todo: put this idk where
Handlebars.registerHelper('json', function (context) {
  return JSON.stringify(context)
})

app.sharedCommunicator
  .getPlayPushes()
  .forEach((msg) => app.player.pause())

app.player.getState()
  .filter((state) => (state === PlayerState.PLAYING))
  .forEach(() => app.sharedCommunicator.pushPlay())

app.player.getQueuePush()
  .forEach((track) => {
    console.log('pushing track', track)
    app.sharedCommunicator.pushQueueTrack(track)
  })

app.sharedCommunicator.getQueueTrackPushes()
  .forEach(async (msg) => {
    console.log(msg)
    const track = await app.modelRepository.getTrack(msg.data.id)

    app.player.queueTrack(track, false)
  })
