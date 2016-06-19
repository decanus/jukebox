CREATE TABLE IF NOT EXISTS tracks (
  id SERIAL PRIMARY KEY,
  duration INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  vevo_id VARCHAR(255) NULL DEFAULT NULL,
  isrc VARCHAR(255) NULL DEFAULT NULL,
  is_live BOOL NOT NULL DEFAULT FALSE,
  is_lyric BOOL NOT NULL DEFAULT FALSE,
  is_audio BOOL NOT NULL DEFAULT FALSE,
  is_music_video BOOL NOT NULL DEFAULT FALSE,
  is_explicit BOOL NOT NULL DEFAULT FALSE,
  permalink VARCHAR(255) NOT NULL,
  release_date DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS artists (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  vevo_id VARCHAR(255) NULL DEFAULT NULL,
  permalink VARCHAR(255) NOT NULL,
  image VARCHAR(255) NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS track_artists (
  id SERIAL PRIMARY KEY,
  artist INT NOT NULL,
  track INT NOT NULL,
  role VARCHAR(11),
  UNIQUE(artist, track),
  FOREIGN KEY (artist) REFERENCES artists(id),
  FOREIGN KEY (track) REFERENCES tracks(id),
  CHECK (role IN ('main', 'featured'))
);

CREATE TABLE IF NOT EXISTS genres (
  id SERIAL PRIMARY KEY,
  name VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS track_genres (
  id SERIAL PRIMARY KEY,
  track INT NOT NULL,
  genre INT NOT NULL,
  UNIQUE(track, genre),
  FOREIGN KEY (track) REFERENCES tracks(id),
  FOREIGN KEY (genre) REFERENCES genres(id)
);

CREATE TABLE IF NOT EXISTS track_sources (
  id SERIAL PRIMARY KEY,
  track INT NOT NULL,
  duration INT NULL DEFAULT NULL,
  source VARCHAR(20) NOT NULL,
  source_data VARCHAR(255) NOT NULL
  CHECK (source IN ('youtube', 'soundcloud')),
  UNIQUE(source, source_data),
  FOREIGN KEY (track) REFERENCES tracks(id)
);

CREATE TABLE IF NOT EXISTS artist_web_profiles (
  id SERIAL PRIMARY KEY,
  artist INT NOT NULL,
  profile VARCHAR(100) NOT NULL,
  profile_data VARCHAR(255) NOT NULL
  CHECK (profile IN ('facebook', 'twitter', 'itunes', 'amazon', 'official_website')),
  FOREIGN KEY (artist) REFERENCES artists(id)
);