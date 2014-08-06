SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

drop table if EXISTS `project`.`staff`;
drop table if exists `project`.`local`;


CREATE SCHEMA IF NOT EXISTS `project` DEFAULT CHARACTER SET latin1 ;
USE `project` ;

-- -----------------------------------------------------
-- Table `project`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project`.`staff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `ssn` CHAR(9) NULL,
  `firstname` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  PRIMARY KEY (`id`)
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `project`.`local`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project`.`local` (
  `id` INT,
  `title` VARCHAR(45) NULL,
    FOREIGN KEY (`id`) REFERENCES `project`.`staff` (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
