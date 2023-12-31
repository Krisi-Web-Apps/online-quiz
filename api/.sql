CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fullname` VARCHAR(100) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lang` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `translations` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `text` TEXT NOT NULL,
  `lang` VARCHAR(20) NOT NULL DEFAULT `bg`,
  INDEX (`lang`)
) ENGINE = InnoDB;

CREATE TABLE `categories` (
  `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `lang` VARCHAR(20) NOT NULL DEFAULT `bg`,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `tests` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `lang` VARCHAR(20) NOT NULL DEFAULT `bg`,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`category_id`) REFERENCES categories(`id`)
) ENGINE = InnoDB;

CREATE TABLE `questions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(1000) NOT NULL,
  `answers` JSON NOT NULL,
  `fact` TEXT NULL,
  `lang` VARCHAR(20) NOT NULL,
  `test_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`test_id`) REFERENCES tests(`id`)
) ENGINE = InnoDB;

CREATE TABLE `users_tests_passed` (
  `user_id` INT NOT NULL,
  `test_id` INT NOT NULL,
  FOREIGN KEY(`test_id`) REFERENCES tests(`id`),
  FOREIGN KEY(`user_id`) REFERENCES users(`id`)
) ENGINE = InnoDB;
