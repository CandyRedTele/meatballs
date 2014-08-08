SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `meatballs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `meatballs` ;

-- -----------------------------------------------------
-- Table `meatballs`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`staff` (
  `name` VARCHAR(45) NULL,
  `ssn` CHAR(9) NULL,
  `address` VARCHAR(45) NULL,
  `phone` CHAR(10) NULL,
  `id` INT NOT NULL AUTO_INCREMENT,
  `global_sid` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`admin` (
  `title` CHAR(3) NULL,
  `location` VARCHAR(55) NULL,
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`staff_id`),
  CONSTRAINT `fk_global_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`id`)
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
    REFERENCES `meatballs`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`menu` (
  `m_id` INT NOT NULL AUTO_INCREMENT,
  `mitem_id` INT NULL,
  PRIMARY KEY (`m_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`facility`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facility` (
  `f_id` INT NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(45) NULL,
  `mid` INT NOT NULL,
  `phone` CHAR(10) NULL,
  PRIMARY KEY (`f_id`),
  INDEX `fk_facility_menu1_idx` (`menu_m_id` ASC),
  CONSTRAINT `fk_facility_menu1`
    FOREIGN KEY (`menu_m_id`)
    REFERENCES `meatballs`.`menu` (`m_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`localstaff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`localstaff` (
  `title` CHAR NULL,
  `start_date` CHAR NULL,
  `f_id` INT NULL,
  `staff_id` INT NOT NULL,
  `facility_f_id` INT NOT NULL,
  PRIMARY KEY (`staff_id`, `f_id`),
  INDEX `fk_local_staff1_idx` (`staff_id` ASC),
  INDEX `fk_local_facility1_idx` (`f_id` ASC),
  CONSTRAINT `fk_local_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_local_facility1`
    FOREIGN KEY (`f_id`)
    REFERENCES `meatballs`.`facility` (`f_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`salary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`salary` (
  `experience` INT NULL,
  `amount` INT NULL COMMENT 'check( title in({\"HR\",\"Accountant\",\"Marketing\"}) receives $40 to 90K\n\ncheck( title in ({\"RestoManager\"}) receives $80 to 100k\n\ncheck( title in ({\"Chef\"}) receives $60 to 100k',
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`staff_id`),
  INDEX `fk_salary_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_salary_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`wage`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wage` (
  `base` DOUBLE NULL,
  `exp_rate` DOUBLE NULL,
  `overtime` DOUBLE NULL,
  `staff_id` INT NOT NULL,
  INDEX `fk_wage_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`staff_id`),
  CONSTRAINT `fk_wage_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`schedule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`schedule` (
  `hours_week` DOUBLE NULL,
  `horus_day` DOUBLE NULL,
  `staff_id` INT NOT NULL,
  INDEX `fk_schedule_staff1_idx` (`staff_id` ASC),
  PRIMARY KEY (`staff_id`),
  CONSTRAINT `fk_schedule_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`supplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` (
  `sku` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `quantity` INT NULL,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`sku`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`food`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`food` (
  `sku` INT NOT NULL,
  `expire_date` CHAR NULL,
  `perishable` CHAR NULL,
  `supplies_sku` INT NOT NULL,
  PRIMARY KEY (`sku`, `supplies_sku`),
  INDEX `fk_food_supplies1_idx` (`supplies_sku` ASC),
  CONSTRAINT `fk_food_supplies1`
    FOREIGN KEY (`supplies_sku`)
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
-- Table `meatballs`.`vendorHasSupplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`vendorHasSupplies` (
  `vendor_name` CHAR(45) NOT NULL,
  `supplies_sku` INT NOT NULL,
  PRIMARY KEY (`vendor_name`, `supplies_sku`),
  INDEX `fk_vendor_has_supplies_supplies1_idx` (`supplies_sku` ASC),
  INDEX `fk_vendor_has_supplies_vendor1_idx` (`vendor_name` ASC),
  CONSTRAINT `fk_vendor_has_supplies_vendor1`
    FOREIGN KEY (`vendor_name`)
    REFERENCES `meatballs`.`vendor` (`v_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendor_has_supplies_supplies1`
    FOREIGN KEY (`supplies_sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalog` (
  `v_id` INT NOT NULL,
  `price` DOUBLE NULL,
  `sku` INT NULL,
  PRIMARY KEY (`v_id`))
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
    REFERENCES `meatballs`.`catalog` (`v_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalog_has_supplies_supplies1`
    FOREIGN KEY (`sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`ingredient`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`ingredient` (
  `amount` VARCHAR(30) NULL,
  `supplies_sku` INT NOT NULL,
  `mitem_id` INT NOT NULL,
  PRIMARY KEY (`supplies_sku`, `mitem_id`),
  INDEX `fk_ingredient_supplies1_idx` (`supplies_sku` ASC),
  CONSTRAINT `fk_ingredient_supplies1`
    FOREIGN KEY (`supplies_sku`)
    REFERENCES `meatballs`.`supplies` (`sku`)
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
  `ingredient_supplies_sku` INT NOT NULL,
  PRIMARY KEY (`mitem_id`),
  INDEX `fk_menu_item_ingredient1_idx` (`ingredient_supplies_sku` ASC),
  CONSTRAINT `fk_menu_item_ingredient1`
    FOREIGN KEY (`ingredient_supplies_sku`)
    REFERENCES `meatballs`.`ingredient` (`supplies_sku`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`wine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wine` (
  `rate` DOUBLE NULL,
  `menu_item_mitem_id` INT NOT NULL,
  PRIMARY KEY (`menu_item_mitem_id`),
  INDEX `fk_wine_menu_item1_idx` (`menu_item_mitem_id` ASC),
  CONSTRAINT `fk_wine_menu_item1`
    FOREIGN KEY (`menu_item_mitem_id`)
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
  `facility_f_id` INT NOT NULL,
  PRIMARY KEY (`r_id`),
  INDEX `fk_reservation_facility1_idx` (`facility_f_id` ASC),
  CONSTRAINT `fk_reservation_facility1`
    FOREIGN KEY (`facility_f_id`)
    REFERENCES `meatballs`.`facility` (`fid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`bill`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`bill` (
  `b_id` INT NOT NULL,
  `total` DOUBLE NULL,
  `facility_f_id` INT NOT NULL,
  PRIMARY KEY (`b_id`, `facility_f_id`),
  INDEX `fk_bill_facility1_idx` (`facility_f_id` ASC),
  CONSTRAINT `fk_bill_facility1`
    FOREIGN KEY (`facility_f_id`)
    REFERENCES `meatballs`.`facility` (`fid`)
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
  `bill_b_id` INT NOT NULL,
  PRIMARY KEY (`g_id`),
  INDEX `fk_golden_bill1_idx` (`bill_b_id` ASC),
  CONSTRAINT `fk_golden_bill1`
    FOREIGN KEY (`bill_b_id`)
    REFERENCES `meatballs`.`bill` (`b_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`article` (
  `mitem_id` INT NOT NULL,
  `bill_b_id` INT NOT NULL,
  PRIMARY KEY (`mitem_id`),
  INDEX `fk_article_bill1_idx` (`bill_b_id` ASC),
  CONSTRAINT `fk_article_bill1`
    FOREIGN KEY (`bill_b_id`)
    REFERENCES `meatballs`.`bill` (`b_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`vendorHasCatalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`vendorHasCatalog` (
  `catalog_v_id` INT NOT NULL,
  `vendor_v_id` INT NOT NULL,
  PRIMARY KEY (`catalog_v_id`, `vendor_v_id`),
  INDEX `fk_catalog_has_vendor_vendor1_idx` (`vendor_v_id` ASC),
  INDEX `fk_catalog_has_vendor_catalog1_idx` (`catalog_v_id` ASC),
  CONSTRAINT `fk_catalog_has_vendor_catalog1`
    FOREIGN KEY (`catalog_v_id`)
    REFERENCES `meatballs`.`catalog` (`v_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalog_has_vendor_vendor1`
    FOREIGN KEY (`vendor_v_id`)
    REFERENCES `meatballs`.`vendor` (`v_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`hasMenuItem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`hasMenuItem` (
  `menu_m_id` INT NOT NULL,
  `menu_item_mitem_id` INT NOT NULL,
  PRIMARY KEY (`menu_m_id`, `menu_item_mitem_id`),
  INDEX `fk_menu_has_menu_item_menu_item1_idx` (`menu_item_mitem_id` ASC),
  INDEX `fk_menu_has_menu_item_menu1_idx` (`menu_m_id` ASC),
  CONSTRAINT `fk_menu_has_menu_item_menu1`
    FOREIGN KEY (`menu_m_id`)
    REFERENCES `meatballs`.`menu` (`m_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_menu_has_menu_item_menu_item1`
    FOREIGN KEY (`menu_item_mitem_id`)
    REFERENCES `meatballs`.`menu_item` (`mitem_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
