(function () {

  'use strict'

  chrome.runtime.onMessage.addListener((message) => {
    document.dispatchEvent(new CustomEvent('jukeboxMediaKey', { detail: message }))
  })

})()
