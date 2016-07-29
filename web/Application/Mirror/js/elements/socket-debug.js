/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export class SocketDebug extends HTMLElement {
  /**
   *
   * @param {SocketWrapper} socket
   */
  constructor (socket) {
    super()
    
    this._socket = socket
    this._onMessage = this._onMessage.bind(this)
  }

  connectedCallback () {
    this._socket.onMessage.addListener(this._onMessage)
  }

  disconnectedCallback () {
    this._socket.onMessage.removeListener(this._onMessage)
  }

  /**
   *
   * @param {{}} message
   * @private
   */
  _onMessage (message) {
    this.appendChild(<pre>{JSON.stringify(message, null, 4)}</pre>)
  }
}
