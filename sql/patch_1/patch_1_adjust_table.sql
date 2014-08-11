SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `meatballs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `meatballs` ;


# drop everything to start fresh
-- DROP TABLE IF EXISTS access;
DROP TABLE IF EXISTS admin;
-- DROP TABLE IF EXISTS article;
-- DROP TABLE IF EXISTS bill;
-- DROP TABLE IF EXISTS catalog;
-- DROP TABLE IF EXISTS catalgoHasSupplies;
-- DROP TABLE IF EXISTS facility;
-- DROP TABLE IF EXISTS facilityHours;
-- DROP TABLE IF EXISTS facilityStock;
-- DROP TABLE IF EXISTS food;
-- DROP TABLE IF EXISTS golden;
-- DROP TABLE IF EXISTS ingredients;
-- DROP TABLE IF EXISTS localstaff;
-- DROP TABLE IF EXISTS menu;
-- DROP TABLE IF EXISTS menu_item;
-- DROP TABLE IF EXISTS hasMenuItem;
-- DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS pay;
-- DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS staff;
-- DROP TABLE IF EXISTS supplies;
-- DROP TABLE IF EXISTS vendor;
-- DROP TABLE IF EXISTS vendorHasCatalog;
DROP TABLE IF EXISTS wage;
-- DROP TABLE IF EXISTS wine;
DROP TABLE IF EXISTS shift;



-- -----------------------------------------------------
-- Table `meatballs`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`staff` 
(
    `staff_id`      INTEGER     PRIMARY KEY     AUTO_INCREMENT,
    `name`          VARCHAR(45) NULL,
    `address`       VARCHAR(45) NULL,
    `phone`         CHAR(12)    NULL,
    `ssn`           CHAR(11)    NULL,   -- TODO fix the number of digits in SSN (should be 9)
    `title`         VARCHAR(45) NOT NULL,
	`acces_level`   INTEGER     NULL CHECK(acces_level in (1,2,3,4,5)) --       COMMENT '1. admin(CEO...) level (all)\n2. local manager level (local resto)\n3. HR level (employees data)\n4. local chef level (food + supplies)\n5. regular level (only personal info)',

--    FOREIGN KEY (`title`) REFERENCES `meatballs`.`pay` (`title`)
--        ON DELETE NO ACTION
--        ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`pay`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`pay` 
(
    `title`         VARCHAR(45) PRIMARY KEY,
    `base`      	DOUBLE NULL,
    `exp_rate`  	DOUBLE NULL     CHECK (exp_rate > 1.0 AND exp_rate < 2.0),      -- N.B. CHECK contraints are ignored in MYSQL
    `train_rate`    DOUBLE NULL     CHECK (train_rate > 1.0 AND train_rate < 2.0)   --      so do NOT bother adding more... You can
);                                                                                  --      use TRIGGERS though.



-- -----------------------------------------------------
-- Table `meatballs`.`shift
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `meatballs`.`shift`
(
    `staff_id`      INTEGER NOT NULL,
    `date`          DATE NOT NULL,
    `time_start`    TIME NOT NULL,
    `time_end`      TIME NOT NULL,
    FOREIGN KEY (`staff_id`) REFERENCES `meatballs`.`staff` (`staff_id`)
);


-- -----------------------------------------------------
-- Table `meatballs`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`admin` 
(
    `staff_id`  INTEGER NOT NULL,
    `location`  VARCHAR(55) NULL DEFAULT 'Montreal',
    `yrs_exp`   INTEGER NULL,
    `training`  VARCHAR(45) NULL,

    CONSTRAINT `fk_admin_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `meatballs`.`staff` (`staff_id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`wage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wage` 
(
  `title` VARCHAR(45)NOT NULL ,
  `base` DOUBLE NULL,
  `exp_rate` DOUBLE NULL,
  `overtime` DOUBLE NULL,
  PRIMARY KEY (`title`))
--  INDEX `fk_wage_staff1_idx` (`staff_id` ASC),
--  CONSTRAINT `fk_wage_staff_id`
--   FOREIGN KEY (`title`)
--    REFERENCES `meatballs`.`staff` (`staff_id`)
--    ON DELETE NO ACTION
--    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`schedule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`schedule` 
(
  `title` VARCHAR(45) NOT NULL,
  `hours_week` DOUBLE NULL,
  `hours_day` DOUBLE NULL,
  PRIMARY KEY (`title`))
--  INDEX `fk_schedule_staff1_idx` (`staff_id` ASC),
--  CONSTRAINT `fk_schedule_staff1`
--    FOREIGN KEY (`staff_id`)
--    REFERENCES `meatballs`.`staff` (`staff_id`)
--    ON DELETE NO ACTION
--    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
