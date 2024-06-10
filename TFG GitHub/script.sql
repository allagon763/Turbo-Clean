SET NAMES UTF8;
CREATE DATABASE IF NOT EXISTS TFG;
USE TFG;

CREATE TABLE IF NOT EXISTS users (
  user_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(30) NOT NULL DEFAULT '',
  login varchar(20) NOT NULL DEFAULT '',
  password varchar(255) NOT NULL DEFAULT '',
  email varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (user_id),
  UNIQUE KEY (user_id, nombre, login, password)
);

CREATE TABLE IF NOT EXISTS reserva (
  reserva_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  fecha date NOT NULL DEFAULT '1970-01-01',
  hora time NOT NULL DEFAULT '00:00:00',
  nombre varchar(50) NOT NULL DEFAULT '',
  user_id int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (reserva_id),
  UNIQUE KEY (reserva_id)
);
