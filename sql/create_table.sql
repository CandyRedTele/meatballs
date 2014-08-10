SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `meatballs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `meatballs` ;


# drop everything to start fresh
DROP TABLE IF EXISTS access;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS bill;
DROP TABLE IF EXISTS catalog;
DROP TABLE IF EXISTS catalgoHasSupplies;
DROP TABLE IF EXISTS facility;
DROP TABLE IF EXISTS facilityHours;
DROP TABLE IF EXISTS facilityStock;
DROP TABLE IF EXISTS food;
DROP TABLE IF EXISTS golden;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS localstaff;
DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS menu_item;
DROP TABLE IF EXISTS hasMenuItem;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS pay;
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS supplies;
DROP TABLE IF EXISTS vendor;
DROP TABLE IF EXISTS vendorHasCatalog;
DROP TABLE IF EXISTS wage;
DROP TABLE IF EXISTS wine;


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
	`acces_level`   INTEGER     NULL CHECK(acces_level in (1,2,3,4,5)), --       COMMENT '1. admin(CEO...) level (all)\n2. local manager level (local resto)\n3. HR level (employees data)\n4. local chef level (food + supplies)\n5. regular level (only personal info)',

    FOREIGN KEY (`title`) REFERENCES `meatballs`.`pay` (`title`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`admin` 
(
    `staff_id`  INTEGER NOT NULL,
    `title`     CHAR(3)     NULL,
    `location`  VARCHAR(55) NULL DEFAULT 'Montreal',
    `yrs_exp`   INTEGER NULL,
    `training`  VARCHAR(45) NULL,

    CONSTRAINT `fk_admin_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `meatballs`.`staff` (`staff_id`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`supplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` 
(
  `sku`     INTEGER NOT NULL,
  `name`    VARCHAR(45) NULL,
  `type`    VARCHAR(45) NULL,
  PRIMARY KEY (`sku`)
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`ingredients` 
(
    `sku` INTEGER NULL,
    `mitem_id` INTEGER NULL,
    `amount` VARCHAR(30) NULL,
    INDEX `fk_ingredient_supplies1_idx` (`sku` ASC),
    CONSTRAINT `fk_ingredients_sku`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `mitem_id`
    FOREIGN KEY (`mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`menu_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`menu_item` 
(
  `mitem_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `category` CHAR(45) NULL,
  `price` DOUBLE NULL,
  `name` VARCHAR(45) NULL,
  `sku` INTEGER NOT NULL,
  INDEX `fk_menu_item_ingredient1_idx` (`sku` ASC),
  CONSTRAINT `fk_menu_item_ingredient1`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`ingredients` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`menu` 
(
  `m_id` INTEGER NOT NULL,
  `type` VARCHAR(45),
  `mitem_id` INTEGER NOT NULL,
  PRIMARY KEY (`m_id`),
  INDEX `mitem_id_idx` (`mitem_id` ASC),
  CONSTRAINT `fk_mitem_id`
    FOREIGN KEY (`mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`facility`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facility` 
(
  `f_id` INTEGER NOT NULL,
  `location` VARCHAR(45) NULL,
  `m_id` INTEGER NOT NULL,
  `phone` CHAR(10) NULL,
  PRIMARY KEY (`f_id`),
  INDEX `fk_facility_menu1_idx` (`m_id` ASC),
  CONSTRAINT `fk_facility_menu1`
    FOREIGN KEY (`m_id`)
    REFERENCES `meatballs`.`menu` (`m_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`localstaff`
-- -----------------------------------------------------
create TABLE IF NOT EXISTS `meatballs`.`localstaff` 

(
  `title`       CHAR NULL,
  `start_date`  CHAR NULL,
  `f_id`        INTEGER NULL,
  `staff_id`    INTEGER NOT NULL,
  INDEX `fk_local_staff1_idx` (`staff_id` ASC, `f_id` ASC),
  INDEX `fk_local_facility1_idx` (`f_id` ASC),
  CONSTRAINT `fk_staff_id2`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_f_id`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `meatballs`.`wage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wage` 
(
  `base` DOUBLE NULL,
  `exp_rate` DOUBLE NULL,
  `overtime` DOUBLE NULL,
  `staff_id` INTEGER NOT NULL,
  INDEX `fk_wage_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_wage_staff_id`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`schedule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`schedule` 
(
  `hours_week` DOUBLE NULL,
  `hours_day` DOUBLE NULL,
  `staff_id` INTEGER NOT NULL,
  INDEX `fk_schedule_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`staff_id`),
  CONSTRAINT `fk_schedule_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`food`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`food` 
(
  `sku` INTEGER NOT NULL,
  `expire_date` CHAR NULL,
  `perishable` CHAR NULL,
  INDEX `sku_idx` (`sku` ASC),
  CONSTRAINT `fk_food_sku`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`vendor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`vendor` 
(
    `v_id` 			INTEGER PRIMARY KEY,
    `company_name` 	CHAR(45) NULL,
    `address` 		VARCHAR(45) NULL
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalog` 
(
  `catalog_id` INTEGER NOT NULL,
  `price` DOUBLE NULL,
  `sku` INTEGER NULL,
  PRIMARY KEY (`catalog_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalgoHasSupplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalgoHasSupplies` 
(
  `v_id` INTEGER NOT NULL,
  `sku` INTEGER NOT NULL,
  PRIMARY KEY (`v_id`, `sku`),
  INDEX `fk_catalog_has_supplies_supplies1_idx` (`sku` ASC),
  INDEX `fk_catalog_has_supplies_catalog1_idx` (`v_id` ASC),
  CONSTRAINT `fk_catalog_has_supplies_catalog1`
    FOREIGN KEY (`v_id`)
    REFERENCES `meatballs`.`catalog` (`catalog_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalog_has_supplies_supplies1`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`wine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wine` 
(
  `rate` DOUBLE NULL,
  `mitem_id` INTEGER NULL,
  INDEX `fk_wine_menu_item1_idx` (`mitem_id` ASC),
  CONSTRAINT `fk_wine_mitem_id`
    FOREIGN KEY (`mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`reservation` 
(
  `r_id` INTEGER NOT NULL,
  `name` VARCHAR(45) NULL,
  `time` DATE NULL,
  `#_seats` INTEGER NULL,
  `event_type` VARCHAR(45) NULL,
  `f_id` INTEGER NOT NULL,
  PRIMARY KEY (`r_id`),
  INDEX `fk_reservation_facility1_idx` (`f_id` ASC),
  CONSTRAINT `fk_reservation_facility1`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`bill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`bill` 
(
  `b_id` INTEGER NOT NULL,
  `total` DOUBLE NULL,
  `f_id` INTEGER NOT NULL,
  PRIMARY KEY (`b_id`),
  INDEX `fk_bill_facility1_idx` (`f_id` ASC),
  CONSTRAINT `fk_bill_f_id`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`golden`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`golden`
(
    `g_id`          INTEGER PRIMARY KEY AUTO_INCREMENT,
    firstname      VARCHAR(45)     NOT NULL,
    `lastname`      VARCHAR(45)     NOT NULL,
    `email`         VARCHAR(45)     NOT NULL,
    phone           CHAR(12)        NULL, 
    picture_path    VARCHAR(100)    NULL,
    `sex`           CHAR(1)    NOT NULL
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS meatballs.golden_has_bills
(
    `g_id`    INTEGER NOT NULL,
    `b_id`    INTEGER PRIMARY KEY,
    CONSTRAINT `fk_golden_has_bills_b_id`
        FOREIGN KEY (`b_id`)
        REFERENCES `meatballs`.`bill` (`b_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_golden_has_bills_g_id`
        FOREIGN KEY (`g_id`)
        REFERENCES meatballs.golden (g_id) 
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`bill_has_menu_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`bill_has_menu_item` 
(
    `b_id`        INTEGER NOT NULL,
    `mitem_id`    INTEGER NOT NULL,
    INDEX `fk_article_bill1_idx` (`b_id` ASC),
    CONSTRAINT fk_bill_has_menu_item_b_id
        FOREIGN KEY (`b_id`)
        REFERENCES `meatballs`.`bill` (`b_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT fk_bill_has_menu_item_mitem_id
    FOREIGN KEY (mitem_id)
    REFERENCES meatballs.menu_item (mitem_id)
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`vendorHasCatalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`vendorHasCatalog` 
(
  `catalog_id` INTEGER NOT NULL,
  `v_id` INTEGER NOT NULL,
  PRIMARY KEY (`catalog_id`, `v_id`),
  INDEX `fk_catalog_has_vendor_vendor1_idx` (`v_id` ASC),
  INDEX `fk_catalog_has_vendor_catalog1_idx` (`catalog_id` ASC),
  CONSTRAINT `fk_catalog_has_vendor_catalog1`
    FOREIGN KEY (`catalog_id`)
    REFERENCES `meatballs`.`catalog` (`catalog_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalog_has_vendor_vendor1`
    FOREIGN KEY (`v_id`)
    REFERENCES `meatballs`.`vendor` (`v_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`hasMenuItem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`hasMenuItem` 
(
  `m_id` INTEGER NOT NULL,
  `mitem_id` INTEGER NOT NULL,
  PRIMARY KEY (`m_id`, `mitem_id`),
  INDEX `fk_menu_has_menu_item_menu_item1_idx` (`mitem_id` ASC),
  INDEX `fk_menu_has_menu_item_menu1_idx` (`m_id` ASC),
  CONSTRAINT `fk_menu_has_menu_item_menu1`
    FOREIGN KEY (`m_id`)
    REFERENCES `meatballs`.`menu` (`m_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_menu_has_menu_item_menu_item1`
    FOREIGN KEY (`mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`facilityHours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityHours` 
(
    `day`   VARCHAR(45) NULL,
    `open`  VARCHAR(45) NULL,
    `close` VARCHAR(45) NULL
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`facilityStock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityStock` 

(
    `quantity`  INTEGER NULL,
    `capacity`  INTEGER NULL,
    `sku`       INTEGER NOT NULL,
    `f_id`      INTEGER NULL,
    INDEX `sku_idx` (`sku` ASC),
    INDEX `f_id_idx` (`f_id` ASC),
    CONSTRAINT `fk_facilityStock_sku`
        FOREIGN KEY (`sku`) REFERENCES `meatballs`.`supplies` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_facilityStock_f_id`
        FOREIGN KEY (`f_id`) REFERENCES `meatballs`.`facility` (`f_id`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`order` 
(
    `f_id`      INTEGER NULL,
    `sku`       INTEGER NULL,
    `order_qty` INTEGER NULL,
    INDEX `f_id_idx` (`f_id` ASC),
    INDEX `sku_idx` (`sku` ASC),
    CONSTRAINT `fk_order_f_id`
        FOREIGN KEY (`f_id`) REFERENCES `meatballs`.`facility` (`f_id`) 
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_order_sku`
        FOREIGN KEY (`sku`) REFERENCES `meatballs`.`supplies` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION
)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;