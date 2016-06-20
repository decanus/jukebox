/**
 *
 * @interface
 * @extends EventTarget
 */
var MessagePort = function () {}

/**
 *
 * @param {*} message
 * @param {Array<Object>} [transfer]
 */
MessagePort.prototype.postMessage = function (message, transfer) {}

/**
 * Starts the sending of messages queued on the port (only needed when using EventTarget.addEventListener; it is implied when using MessagePort.onmessage.)
 */
MessagePort.prototype.start = function () {}

/**
 * Disconnects the port, so it is no longer active.
 */
MessagePort.prototype.close = function () {}

MessagePort.prototype.onmessage = 0

/**
 * 
 * @type {MessagePort}
 */
SharedWorker.prototype.port = null
