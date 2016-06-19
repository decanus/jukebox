/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

self.addEventListener('connect', (e) => {
  const port = e.ports[0]

  port.postMessage(counter)
})
