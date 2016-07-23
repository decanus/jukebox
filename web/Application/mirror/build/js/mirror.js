(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.Signal = Signal;
/**
 *
 * @template T
 * @constructor
 */
function Signal() {}

/**
 *
 * @param {(function(value: T))} callbackFn
 */
Signal.prototype.addListener = function (callbackFn) {
  if (this._listeners == null) {
    this._listeners = new Set();
  }

  this._listeners.add(callbackFn);
};

Signal.prototype.removeListener = function (callbackFn) {
  if (this._listeners == null) {
    return;
  }

  this._listeners.delete(callbackFn);
};

/**
 *
 * @param {T} [value]
 */
Signal.prototype.dispatch = function (value) {
  if (this._listeners == null) {
    return;
  }

  this._listeners.forEach(function (listener) {
    return listener(value);
  });
};


},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.SubscribeMessage = SubscribeMessage;
/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 * 
 * @param {string} mirrorId
 * @returns {{type: string, action: string, mirrorId: string}}
 * @constructor
 */
function SubscribeMessage(mirrorId) {
  return { type: 'action', action: 'subscribe', mirrorId: mirrorId };
}


},{}],3:[function(require,module,exports){
'use strict';

var _socketWrapper = require('./socket/socket-wrapper');

var _subscribeMessage = require('./message/subscribe-message');

/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

var socket = new _socketWrapper.SocketWrapper('ws://devsocket.jukebox.ninja/mirror');

socket.connect();

socket.onMessage.addListener(function (msg) {
  console.log(msg);
});

socket.send((0, _subscribeMessage.SubscribeMessage)('1'));


},{"./message/subscribe-message":2,"./socket/socket-wrapper":4}],4:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.SocketWrapper = undefined;

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }(); /**
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      * (c) 2016 Jukebox <www.jukebox.ninja>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      */

var _signal = require('../event/signal');

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var SocketWrapper = exports.SocketWrapper = function () {
  /**
   *
   * @param {string} url
   * @param {number} [reconnectInterval]
   */
  function SocketWrapper(url) {
    var reconnectInterval = arguments.length <= 1 || arguments[1] === undefined ? 5000 : arguments[1];

    _classCallCheck(this, SocketWrapper);

    this._url = url;
    this._reconnectInterval = reconnectInterval;
    this._onMessage = new _signal.Signal();
    this._open = false;
    this._messages = new Set();

    this._onSocketOpen = this._onSocketOpen.bind(this);
    this._onSocketClose = this._onSocketClose.bind(this);
    this._onSocketMessage = this._onSocketMessage.bind(this);
  }

  _createClass(SocketWrapper, [{
    key: '_onSocketOpen',
    value: function _onSocketOpen() {
      var _this = this;

      this._open = true;

      this._messages.forEach(function (msg) {
        return _this.send(msg);
      });
      this._messages = new Set();
    }
  }, {
    key: '_onSocketClose',
    value: function _onSocketClose() {
      var _this2 = this;

      this._open = false;

      console.info('connection lost, reconnecting in 5s...');

      setTimeout(function () {
        return _this2.connect();
      }, this._reconnectInterval);
    }

    /**
     *
     * @param {MessageEvent} event
     * @private
     */

  }, {
    key: '_onSocketMessage',
    value: function _onSocketMessage(event) {
      this._onMessage.dispatch(JSON.parse(event.data));
    }

    /**
     *
     * @returns {Signal}
     */

  }, {
    key: 'connect',
    value: function connect() {
      this._socket = new WebSocket(this._url);

      this._socket.addEventListener('open', this._onSocketOpen);
      this._socket.addEventListener('close', this._onSocketClose);
      this._socket.addEventListener('message', this._onSocketMessage);
    }

    /**
     *
     * @param {{}} message
     */

  }, {
    key: 'send',
    value: function send(message) {
      if (!this._open) {
        this._messages.add(message);
        return;
      }

      this._socket.send(JSON.stringify(message));
    }
  }, {
    key: 'onMessage',
    get: function get() {
      return this._onMessage;
    }
  }]);

  return SocketWrapper;
}();


},{"../event/signal":1}]},{},[3]);
