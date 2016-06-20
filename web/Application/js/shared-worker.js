/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

/**
 *
 * @type {Set<MessagePort>}
 */
const ports = new Set()

/**
 *
 * @param {{}} data
 */
function broadcastMessage(data) {
  ports.forEach((port) => port.postMessage(data))
}

/**
 * 
 * @param {MessagePort} port
 */
function cleanupPort(port) {
  ports.delete(port)
  port.close()
}

/**
 * 
 * @param {{ type: string }} data
 * @param {MessagePort} port
 */
function handleMessage(data, port) {
  switch(data.type) {
    case 'push':
      return broadcastMessage(data)
    case 'closing':
      return cleanupPort(port)
  }
}

self.addEventListener('connect', (event) => {
  const port = event.ports[0]

  port.addEventListener('message', (event) => handleMessage(event.data, port))
  port.start()
  
  ports.add(port)
})
