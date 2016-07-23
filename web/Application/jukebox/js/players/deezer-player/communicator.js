import { Emitter } from '../../event/emitter'
import { ORIGIN, PLAYER_URL } from './constants'
import { buildQuery } from '../../url/query'
import { createObservable } from '../../dom/events/create-observable'

/**
 *
 * @param {string} appId
 * @returns {HTMLIFrameElement}
 */
function createFrame (appId) {
  const params = buildQuery([
    [ 'emptyPlayer', 'true' ],
    [ 'channel', '' ],
    [ 'app_id', appId ]
  ])

  const frame = document.body.appendChild(document.createElement('iframe'))

  frame.style.border = 'none'
  frame.style.width = '0'
  frame.style.height = '0'

  frame.src = `${PLAYER_URL}?${params}`

  return frame
}

/**
 *
 * @param communicator
 * @returns {function(MessageEvent): boolean}
 */
function originMatches (communicator) {
  return (event) => {
    return event.origin === ORIGIN && event.source === communicator._frame.contentWindow
  }
}

/**
 *
 * @param {Communicator} communicator
 * @returns {Observable<{}>}
 */
function createMessagesObservable (communicator) {
  return createObservable(window, 'message')
    .filter(originMatches(communicator))
    .map((evt) => JSON.parse(evt.data))
}

/**
 *
 * @param {Observable} messages
 * @returns {Observable}
 */
function getEvents (messages) {
  return messages
    .filter((msg) => msg.method === 'DZ.player.receiveEvent')
    .map((msg) => msg.args)
}

/**
 *
 * @param {Observable} messages
 * @returns {Promise}
 */
function getReady (messages) {
  return messages
    .filter((msg) => msg.method === 'DZ.onDeezerLoaded')
    .once()
}

export class Communicator extends Emitter {
  /**
   *
   * @param {string} appId
   */
  constructor (appId) {
    super()

    /**
     *
     * @type {HTMLIFrameElement}
     * @private
     */
    this._frame = createFrame(appId)

    /**
     *
     * @type {Observable<{}>}
     * @private
     */
    this._messages = createMessagesObservable(this)

    /**
     *
     * @type {Promise}
     * @private
     */
    this._ready = getReady(this._messages)

    /**
     *
     * @type {Observable<{}>}
     * @private
     */
    this._events = getEvents(this._messages)
  }

  /**
   *
   * @param {{}} data
   * @private
   */
  _postMessage (data) {
    this._frame.contentWindow.postMessage(JSON.stringify(data), ORIGIN)
  }

  /**
   *
   * @param {string} method
   * @param {{}} args
   */
  sendMethod (method, args) {
    return this._postMessage({ method, args })
  }

  /**
   *
   * @param {string} command
   * @param {*} [value]
   */
  sendCommand (command, value) {
    let data = { command }

    if (value !== undefined) {
      data.value = value
    }

    return this.sendMethod('DZ.player_controler.doAction', data)
  }

  /**
   *
   * @returns {Observable<{}>}
   */
  getMessages () {
    return this._messages
  }

  /**
   *
   * @returns {Observable<{}>}
   */
  getEvents () {
    return this._events
  }

  /**
   *
   * @returns {Promise}
   */
  ready () {
    return this._ready
  }
}
