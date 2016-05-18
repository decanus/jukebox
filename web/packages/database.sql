CREATE DATABASE IF NOT EXISTS jukebox
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE jukebox;

CREATE TABLE IF NOT EXISTS `tracks` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  duration INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  youtubeID VARCHAR(20) DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS `artists` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  urlSafeName VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `trackArtists` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  artist INT NOT NULL,
  track INT NOT NULL,
  role VARCHAR(11),
  FOREIGN KEY (artist) REFERENCES artists(id),
  FOREIGN KEY (track) REFERENCES tracks(id),
  CHECK (role IN ('main', 'featured'))
);

CREATE TABLE IF NOT EXISTS `genres` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS `trackGenres` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  track INT NOT NULL,
  genre INT NOT NULL,
  FOREIGN KEY (track) REFERENCES tracks(id),
  FOREIGN KEY (genre) REFERENCES genres(id)
)