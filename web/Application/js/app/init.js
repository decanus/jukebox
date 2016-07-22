/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'
import { fetchUser } from '../app/apr'
import { User } from '../value/user'

//noinspection JSUnresolvedVariable
if (window.__$models) {
  //noinspection JSUnresolvedVariable
  window.__$models.forEach((model) => app.modelRepository.add(model))
}

fetchUser()
  .then((user) => {
    if (user.length === 0) {
      app.user = null
    } else {
      app.user = new User(user.username, user.email)
    }
  })
