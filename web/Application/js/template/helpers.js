/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

export const helpers = Object.create(Handlebars.helpers, {
  json: {
    value (context) {
      return JSON.stringify(context)
    }
  }
})
