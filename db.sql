-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(55) NOT NULL,
  `lastname` VARCHAR(55) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `bio` VARCHAR(255) NULL,
  `country` VARCHAR(45) NULL,
  `birthdate` DATE NULL,
  `profile_pic` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`faves`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`faves` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` INT(11) NULL,
  `user_id` INT(11) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_faves_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_faves_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`followings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`followings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `follower_id` INT(11) NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_following_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_following_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`tweets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tweets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tweet` VARCHAR(280) NULL DEFAULT NULL,
  `picture` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tweets_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_tweets_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`replies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`replies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `tweet_id` INT(11) NOT NULL,
  `content` VARCHAR(280),
  `picture` VARCHAR(255),
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_replies_users1_idx` (`user_id` ASC),
  INDEX `fk_replies_tweets1_idx` (`tweet_id` ASC),
  CONSTRAINT `fk_replies_tweets1`
    FOREIGN KEY (`tweet_id`)
    REFERENCES `mydb`.`tweets` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_replies_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mydb`.`likes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`likes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `reply_id` INT(11) NOT NULL COMMENT 'Replies kunnen liken',
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_like (replies)_users1_idx` (`user_id` ASC),
  INDEX `fk_like (replies)_replies1_idx` (`reply_id` ASC),
  CONSTRAINT `fk_like (replies)_replies1`
    FOREIGN KEY (`reply_id`)
    REFERENCES `mydb`.`replies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_like (replies)_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `mydb`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;