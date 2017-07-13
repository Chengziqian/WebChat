DROP DATABASE IF EXISTS Chat;
CREATE DATABASE Chat CHARACTER SET utf8;
USE Chat;
CREATE TABLE message(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `message` TEXT,
  `time` DATETIME,
  `username` TEXT BINARY
);
CREATE TABLE user(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` TEXT BINARY,
  `password` TEXT BINARY
);
CREATE TABLE online_user(
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` TEXT BINARY,
  `session_id` TEXT,
  `deadline` DATETIME
);
