'use strict'

const fs = require('fs')
const path = require('path')
const Server = require('ws').Server
const spawn = require('child_process').spawnSync

const ws = new Server({ port: 8081 })
const connections = new Set()

const basedir = path.join(__dirname, '../..')

const broadcast = (msg) => {
  const encoded = JSON.stringify(msg)
  
  connections.forEach((ws) => ws.send(encoded))
}

fs.watch(basedir, { recursive: true }, (event, filename) => {
  broadcast({
    event: 'build-start'
  })
  
  spawn('make', [], { cwd: path.join(basedir, 'Application') })
  spawn('make', [], { cwd: path.join(basedir, 'Styles') })

  broadcast({
    event: 'build-complete'
  })
})

ws.on('connection', (connection) => {
  connections.add(connection)
  
  connection.on('close', () => {
    connections.delete(connection)
  })
})
