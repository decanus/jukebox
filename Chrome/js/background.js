/**
 * (c) 2016 Jukebox Ninja <www.jukebox.ninja>
 */
(function () {

  'use strict'

  chrome.commands.onCommand.addListener((command) => {
    chrome.tabs.query({ url: '*://*.jukebox.ninja/*' }, (tabs) => {
      tabs.forEach((tab) => {
        chrome.tabs.sendMessage(tab.id, { command: command })
      })
    })
  })
})()
