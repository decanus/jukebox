CREATE DATABASE jukebox
  ENCODING 'UTF8'
  LC_COLLATE = 'en_US.UTF-8'
  LC_CTYPE = 'en_US.UTF-8';

CREATE ROLE jukebox WITH PASSWORD 'jukebox' SUPERUSER LOGIN;
