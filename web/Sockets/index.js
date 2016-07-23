/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

const cli = require('./lib/cli')
const redis = require('redis')
const Server = require('ws').Server
const config = require('./data/config.json')

const args = cli.parseFlags(process.argv.slice(2))

const instance = Number.parseInt(args.get('instance'))
const port = config.instances[instance]

const server = new Server({ port })
const clients = new Set()
const redisClient = redis.createClient(config.redisPort, config.redisHost)

server.on('connection', (client) => {
  clients.add(client)
  client.on('close', () => clients.delete(client))

  // todo: remove for live
  client.send(JSON.stringify({ action: 'info', instance: instance }))
})

redisClient.on('message', (channel, message) => {
  clients.forEach((client) => client.send(JSON.stringify(message)))
})

redisClient.subscribe('FOOBAR')

console.log(`Listening on port ${port}`)
