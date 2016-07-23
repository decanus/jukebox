/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

'use strict'

const cli = require('./lib/cli')
const SubscriptionManager = require('./lib/subscription-manager')
const Client = require('./lib/client')
const redis = require('redis')
const Server = require('ws').Server
const config = require('./data/config.json')

const args = cli.parseFlags(process.argv.slice(2))

const instance = Number.parseInt(args.get('instance'))
const port = config.instances[ instance ]

const server = new Server({ port })
const redisClient = redis.createClient(config.redisPort, config.redisHost)

const subscriptionManager = new SubscriptionManager(redisClient)

server.on('connection', (_client) => {
  const client = new Client(_client)

  client.send({ action: 'info', instance: instance })

  client.onMessage.addListener((message) => {
    if (message.action === 'subscribe') {
      subscriptionManager.subscribe(client, message.mirrorId)
    }
  })

  client.onDisconnect.addListener(() => {
    subscriptionManager.unsubscribe(client)
  })
})

redisClient.on('message', (channel, message) => {
  subscriptionManager.broadcastRaw(channel, message)
})

console.log(`Listening on port ${port}`)
