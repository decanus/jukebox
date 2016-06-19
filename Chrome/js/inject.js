/**
 * (c) 2016 Jukebox Ninja <www.jukebox.ninja>
 */
(function () {

  'use strict'

  chrome.runtime.onMessage.addListener((message) => {
    document.dispatchEvent(new CustomEvent('jukeboxMediaKey', { detail: message }))
  })

})()
