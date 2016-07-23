/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

const cli = require('./lib/cli')
const redis = require('redis')
const Server = require('ws').Server
const config = require('./data/config.json')

const args = cli.parseFlags(process.argv.slice(2))
const port = args.get('port')
const server = new Server({ port })
const redisClient = redis.createClient(config.redisPort, config.redisHost)

server.on('connection', (client) => {
  client.send(JSON.stringify({ action: `hello from ${port}` }))
})

console.log(`Listening on port ${port}`)


