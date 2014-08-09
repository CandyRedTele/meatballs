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
DROP TABLE IF EXISTS `local`;
DROP TABLE IF EXISTS `localstaff`;
DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS menu_item;
DROP TABLE IF EXISTS hasMenuItem;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS pay;
DROP TABLE IF EXISTS reservation;
DROP TABLE IF EXISTS salary;
DROP TABLE IF EXISTS `schedule`;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS supplies;
DROP TABLE IF EXISTS vendor;
DROP TABLE IF EXISTS vendorHasCatalog;
DROP TABLE IF EXISTS wage;
DROP TABLE IF EXISTS wine;


-- -----------------------------------------------------
-- Table `meatballs`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`staff` (
  `name` VARCHAR(45) NULL,
  `ssn` CHAR(9) NULL,
  `address` VARCHAR(45) NULL,
  `phone` CHAR(20) NULL,
  `staff_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NULL,
  PRIMARY KEY (`staff_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`admin` (
  `title` CHAR(3) NULL,
  `location` VARCHAR(55) NULL DEFAULT 'Montreal',
  `staff_id` INT NOT NULL,
  `yrs_exp` INT NULL,
  `training` VARCHAR(45) NULL,
  CONSTRAINT `staff_id`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`access`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`access` (
  `level#` INT NULL COMMENT '1. admin(CEO...) level (all)\n2. local manager level (local resto)\n3. HR level (employees data)\n4. local chef level (food + supplies)\n5. regular level (only personal info)',
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`staff_id`),
  INDEX `fk_Access_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_Access_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`supplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` (
  `sku` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`sku`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`ingredients` (
  `amount` VARCHAR(30) NULL,
  `sku` INT NULL,
  `mitem_id` INT NULL,
  INDEX `fk_ingredient_supplies1_idx` (`sku` ASC),
  CONSTRAINT `sku`
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
CREATE TABLE IF NOT EXISTS `meatballs`.`menu_item` (
  `mitem_id` INT NOT NULL,
  `category` CHAR(45) NULL,
  `price` DOUBLE NULL,
  `name` VARCHAR(45) NULL,
  `sku` INT NOT NULL,
  PRIMARY KEY (`mitem_id`),
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
CREATE TABLE IF NOT EXISTS `meatballs`.`menu` (
  `m_id` INT NOT NULL,
  `type` VARCHAR(45),
  `mitem_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`facility` (
  `f_id` INT NOT NULL,
  `location` VARCHAR(45) NULL,
  `m_id` INT NOT NULL,
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
  `title` 		CHAR NULL,
  `start_date` 	CHAR NULL,
  `f_id` 		INT NULL,
  `staff_id` 	INT NOT NULL,
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
-- Table `meatballs`.`pay`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`pay` (
  `title` VARCHAR(45) NOT NULL,
  `exp_rate` DOUBLE NULL,
  `base` DOUBLE NULL,
  `train_rate` DOUBLE NULL,
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`title`),
  INDEX `fk_salary_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_staff_id`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);



-- -----------------------------------------------------
-- Table `meatballs`.`wage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wage` (
  `base` DOUBLE NULL,
  `exp_rate` DOUBLE NULL,
  `overtime` DOUBLE NULL,
  `staff_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`schedule` (
  `hours_week` DOUBLE NULL,
  `hours_day` DOUBLE NULL,
  `staff_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`food` (
  `sku` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`vendor` (
  `v_id` INT NOT NULL,
  `company_name` CHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  PRIMARY KEY (`v_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalog` (
  `catalog_id` INT NOT NULL,
  `price` DOUBLE NULL,
  `sku` INT NULL,
  PRIMARY KEY (`catalog_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalgoHasSupplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalgoHasSupplies` (
  `v_id` INT NOT NULL,
  `sku` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`wine` (
  `rate` DOUBLE NULL,
  `mitem_id` INT NULL,
  INDEX `fk_wine_menu_item1_idx` (`mitem_id` ASC),
  CONSTRAINT `fk_wine_mitem_id`
    FOREIGN KEY (`mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`reservation` (
  `r_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `time` DATE NULL,
  `#_seats` INT NULL,
  `event_type` VARCHAR(45) NULL,
  `f_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`bill` (
  `b_id` INT NOT NULL,
  `total` DOUBLE NULL,
  `f_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`golden` (
  `g_id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `b_id` INT NOT NULL,
  PRIMARY KEY (`g_id`),
  INDEX `fk_golden_bill1_idx` (`b_id` ASC),
  CONSTRAINT `fk_golden_bill1`
    FOREIGN KEY (`b_id`)
    REFERENCES `meatballs`.`bill` (`b_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`article` (
  `mitem_id` INT NOT NULL,
  `b_id` INT NOT NULL,
  PRIMARY KEY (`mitem_id`),
  INDEX `fk_article_bill1_idx` (`b_id` ASC),
  CONSTRAINT `fk_article_bill1`
    FOREIGN KEY (`b_id`)
    REFERENCES `meatballs`.`bill` (`b_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`vendorHasCatalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`vendorHasCatalog` (
  `catalog_id` INT NOT NULL,
  `v_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`hasMenuItem` (
  `m_id` INT NOT NULL,
  `mitem_id` INT NOT NULL,
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
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityHours` (
  `day` VARCHAR(45) NULL,
  `open` VARCHAR(45) NULL,
  `close` VARCHAR(45) NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`facilityStock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityStock` (
  `quantity` INT NULL,
  `capacity` INT NULL,
  `sku` INT NOT NULL,
  `f_id` INT NULL,
  INDEX `sku_idx` (`sku` ASC),
  INDEX `f_id_idx` (`f_id` ASC),
  CONSTRAINT `fk_facilityStock_sku`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_facilityStock_f_id`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`order` (
  `f_id` INT NULL,
  `sku` INT NULL,
  `order_qty` INT NULL,
  INDEX `f_id_idx` (`f_id` ASC),
  INDEX `sku_idx` (`sku` ASC),
  CONSTRAINT `fk_order_f_id`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_sku`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
