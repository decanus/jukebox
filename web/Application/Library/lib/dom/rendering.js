/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

let waitingNextRender = false
let afterNextRenderQueue = []

export const RenderingStatus = { afterNextRender }

/**
 *
 * @param {Function} callbackFn
 */
function afterNextRender (callbackFn) {
  watchNextRender()
  afterNextRenderQueue.push(callbackFn)
}

function watchNextRender () {
  if (!waitingNextRender) {
    waitingNextRender = true

    const fn = () => {
      afterNextRenderQueue.forEach((callbackFn) => callbackFn())
      afterNextRenderQueue = []
      waitingNextRender = false
    }

    //noinspection JSCheckFunctionSignatures
    requestAnimationFrame(() => setTimeout(fn))
  }
}
