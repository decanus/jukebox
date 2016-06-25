/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export const helpers = Object.assign({}, Handlebars.helpers, {
  json (context) {
    return JSON.stringify(context)
  }
})
