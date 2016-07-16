/**
 * (c) 2016 Jukebox <www.jukebox.ninja>
 */

import { resolvePath } from '../app/apr'
import { app } from '../app'

const staticRoutes = {
  '/': 'homepage',
  '/error': 'error',
  '/login': 'login',
  '/signup': 'register'
}

/**
 * @typedef {{ name: string, data: * }} ResolvedRoute
 */

/**
 *
 * @param path
 * @returns {ResolvedRoute|null}
 */
async function resolveSpecial (path) {
  const resolved = await resolvePath(path)

  if (resolved.status === 404) {
    return null
  }

  const model = app.modelRepository.add(resolved)

  return getSpecialView(model)
}

/**
 *
 * @param {{ id: number, type: string }} model
 * @returns {ResolvedRoute|null}
 */
function getSpecialView (model) {
  switch (model.type) {
    case 'artists':
      return { name: 'artist', data: model.id }
    case 'tracks':
      // todo: implement
      return null
  }

  throw new Error(`no route for model with type ${model.type}`)
}

/**
 *
 * @param {Route} route
 * @returns {ResolvedRoute|null}
 */
function resolveCached (route) {
  const cache = app.resolveCache
  const path = route.path

  if (!cache.has(path)) {
    return null
  }

  return getSpecialView(cache.get(path))
}

/**
 *
 * @param {Route} route
 * @returns {ResolvedRoute|null}
 */
function resolveStatic (route) {
  const path = route.path

  if (!staticRoutes.hasOwnProperty(path)) {
    return null
  }

  return { name: staticRoutes[path] }
}

/**
 *
 * @param {Route} route
 * @returns {ResolvedRoute}
 * @todo rename and move
 * @todo generic resovers handling
 */
export async function resolveView (route) {
  const cached = resolveCached(route)

  if (cached) {
    return cached
  }

  const resolvedStatic = resolveStatic(route)

  if (resolvedStatic) {
    return resolvedStatic
  }

  if (route.pathParts[ 0 ] === 'search') {
    // todo: should we do this here?
    return { name: 'search', data: {
      query: route.params.get('q') || '',
      includes: [route.params.get('type') || 'everything']
    }}
  }

  const special = await resolveSpecial(route.path)

  if (special) {
    return special
  }

  return { name: 'not-found', data: { uri: route } }
}
