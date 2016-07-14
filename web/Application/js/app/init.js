/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { app } from '../app'

//noinspection JSUnresolvedVariable
if (window.__$models) {
  //noinspection JSUnresolvedVariable
  window.__$models.forEach((model) => app.modelRepository.add(model))
}
