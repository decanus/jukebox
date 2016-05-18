CREATE DATABASE jukebox
  ENCODING 'UTF8'
  LC_COLLATE = 'en_US.UTF-8'
  LC_CTYPE = 'en_US.UTF-8';

CREATE USER jukebox WITH PASSWORD 'jukebox';
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO jukebox;

CREATE TABLE IF NOT EXISTS tracks (
  id SERIAL PRIMARY KEY,
  duration INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  youtubeID VARCHAR(20) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS artists (
  id SERIAL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  urlSafeName VARCHAR(255) NOT NULL,
  isVevo BOOL NOT NULL DEFAULT FALSE,
  officialWebsite VARCHAR(255) NULL DEFAULT NULL,
  twitter VARCHAR(255) NULL DEFAULT NULL,
  facebook VARCHAR(255) NULL DEFAULT NULL,
  itunes VARCHAR(255) NULL DEFAULT NULL,
  amazon VARCHAR(255) NULL DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS trackArtists (
  id SERIAL PRIMARY KEY,
  artist INT NOT NULL,
  track INT NOT NULL,
  role VARCHAR(11),
  FOREIGN KEY (artist) REFERENCES artists(id),
  FOREIGN KEY (track) REFERENCES tracks(id),
  CHECK (role IN ('main', 'featured'))
);

CREATE TABLE IF NOT EXISTS genres (
  id SERIAL PRIMARY KEY,
  name VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS trackGenres (
  id SERIAL PRIMARY KEY,
  track INT NOT NULL,
  genre INT NOT NULL,
  FOREIGN KEY (track) REFERENCES tracks(id),
  FOREIGN KEY (genre) REFERENCES genres(id)
);
