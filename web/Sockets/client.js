var socket = new WebSocket('ws://devsocket.jukebox.ninja/mirror')

socket.addEventListener('message', (event) => {
  const msg = JSON.parse(event.data)
  
  console.log(msg)  
})

window.socket = socket
