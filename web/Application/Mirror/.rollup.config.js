import babel from 'rollup-plugin-babel'
import uglify from 'rollup-plugin-uglify'

const isLive = process.env[ 'JUKEBOX_ENV' ] === 'production'
const plugins = [ babel() ]

if (isLive) {
  plugins.push(uglify())
}

export default {
  plugins: plugins,
  sourceMap: !isLive,
  format: 'iife'
}
