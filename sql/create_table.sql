SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `meatballs`;
CREATE SCHEMA IF NOT EXISTS `meatballs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `meatballs` ;


# drop everything to start fresh       Generation
DROP TABLE IF EXISTS admin;             -- DONE
DROP TABLE IF EXISTS bill;              -- DONE
DROP TABLE IF EXISTS catalog;           -- DONE
DROP TABLE IF EXISTS facility;          -- DONE
DROP TABLE IF EXISTS facilityHours;     -- DONE
DROP TABLE IF EXISTS facilityStock;     -- DONE
DROP TABLE IF EXISTS food;              -- DONE
DROP TABLE IF EXISTS golden;            -- DONE
DROP TABLE IF EXISTS ingredients;       -- DONE
DROP TABLE IF EXISTS localstaff;        -- DONE
DROP TABLE IF EXISTS menu;              -- DONE
DROP TABLE IF EXISTS menu_item;         -- DONE
DROP TABLE IF EXISTS `order`;           -- DONE
DROP TABLE IF EXISTS pay;               -- DONE
DROP TABLE IF EXISTS reservation;       -- 
DROP TABLE IF EXISTS schedule;          -- 
DROP TABLE IF EXISTS staff;             -- DONE
DROP TABLE IF EXISTS supplies;          -- DONE
DROP TABLE IF EXISTS vendor;            -- DONE
DROP TABLE IF EXISTS wage;              -- DONE
DROP TABLE IF EXISTS wine;              -- DONE
DROP TABLE IF EXISTS shift;             -- DONE
DROP TABLE IF EXISTS access_level;      -- DONE
DROP TABLE IF EXISTS facilityBalance;   -- DONE
DROP TABLE IF EXISTS bill_has_menu_item;-- DONE
DROP TABLE IF EXISTS golden_has_bills;  -- DONE

-- -----------------------------------------------------
-- Table `meatballs`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`staff` 
(
    `staff_id`      INTEGER     PRIMARY KEY     AUTO_INCREMENT,
    `name`          VARCHAR(45) NULL,
    `address`       VARCHAR(60) NULL,
    `phone`         CHAR(12)    NULL,
    `ssn`           CHAR(11)    NULL,
    `title`         VARCHAR(45) NOT NULL
	-- `access_level`   INTEGER     NULL CHECK(access_level in (1,2,3,4,5)) --       COMMENT '1. admin(CEO...) level (all)\n2. local manager level (local resto)\n3. HR level (employees data)\n4. local chef level (food + supplies)\n5. regular level (only personal info)',
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`access_level`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `meatballs`.`access_level`
(
    `title`         VARCHAR(45) PRIMARY KEY, 
    `access_level`  INTEGER NOT NULL
);

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
-- Table `meatballs`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`admin` 
(
    `staff_id`  INTEGER NOT NULL,
    `location`  VARCHAR(55) NULL DEFAULT 'Montreal',
    `yrs_exp`   INTEGER     NOT NULL DEFAULT 0,
    `training`  VARCHAR(255) NULL,
    PRIMARY KEY (staff_id, location), -- Assuming that an employee might work in different locations during his career.
    CONSTRAINT `fk_admin_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `meatballs`.`staff` (`staff_id`)
        ON DELETE CASCADE
        ON UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`supplies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` 
(
  `sku`     INTEGER NOT NULL,
  `name`    VARCHAR(85) NULL,
  `type`    VARCHAR(45) NULL,
  `price`   DECIMAL (15,2) DEFAULT 0.0,
  PRIMARY KEY (`sku`)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`menu_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`menu_item` 
(
  `mitem_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `category` CHAR(45) NULL,
  `price` DECIMAL(15,2) NULL,
  `name` VARCHAR(65) NULL,
  `image` VARCHAR(95) NULL
)
ENGINE = InnoDB;



-- -----------------------------------------------------
-- Table `meatballs`.`ingredients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`ingredients`
(
    `mitem_id`   INTEGER, 
    `sku`       INTEGER,
    `amount`    INTEGER NULL,
    PRIMARY KEY (mitem_id, sku),
    CONSTRAINT `fk_ingredients_mitem_id`
        FOREIGN KEY (`mitem_id`)
        REFERENCES `meatballs`.`menu_item` (`mitem_id`)
        ON DELETE NO ACTION 
        ON UPDATE CASCADE
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`menu`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`menu` 
(
  `m_id` INTEGER NOT NULL,
  `mitem_id` INTEGER NOT NULL,
  PRIMARY KEY (`m_id`,`mitem_id`),
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
  `address` VARCHAR(100) NULL,
  `m_id` INTEGER NOT NULL,
  `phone` CHAR(13) NULL,
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
  `start_date`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `f_id`        INTEGER NULL,
  `staff_id`    INTEGER PRIMARY KEY,
  `training`    VARCHAR(255) DEFAULT 'n/a',
  CONSTRAINT `fk_staff_id2`
    FOREIGN KEY (`staff_id`)
    REFERENCES `meatballs`.`staff` (`staff_id`)
    ON DELETE CASCADE
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
  `title` VARCHAR(45)NOT NULL ,
  `base` DOUBLE NULL,
  `exp_rate` DOUBLE NULL,
  `overtime` DOUBLE NULL,
  PRIMARY KEY (`title`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`schedule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`schedule` 
(
  `title` VARCHAR(45) NOT NULL,
  `min_per_week` INT DEFAULT 0,
  `max_per_week` INT NOT NULL,
  `min_per_day` INT DEFAULT 0,
  `max_per_day` INT NOT NULL,
  PRIMARY KEY (`title`)
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`food`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`food` 
(
  `sku` INTEGER NOT NULL,
  `capacity`  INTEGER  NOT NULL,
  `days_till_expired` INT NOT NULL,
  `perishable` BOOLEAN NULL,
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
    `vendor_id` 	INTEGER PRIMARY KEY,
    `company_name` 	VARCHAR(45) NULL,
    `address` 		VARCHAR(45) NULL
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`catalog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`catalog` 
(
    `vendor_id`     INTEGER, 
    `sku`           INTEGER, 
    PRIMARY KEY (vendor_id, sku),
    CONSTRAINT `fk_catalog_vendor_id`
        FOREIGN KEY (`vendor_id`)
        REFERENCES meatballs.vendor (vendor_id)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION,
    CONSTRAINT `fk_catalog_sku`
        FOREIGN KEY (`sku`)
        REFERENCES meatballs.supplies(sku)
        ON DELETE NO ACTION
        ON UPDATE NO ACTION

)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`wine`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`wine` 
(
    
    `rate` DECIMAL (15,2) DEFAULT 0.0,
    `mitem_id` INTEGER NULL,
    PRIMARY KEY (mitem_id),
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
  `r_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `nb_of_seats` INTEGER DEFAULT 1,
  `event_type` VARCHAR(25) NULL,
  `f_id` INTEGER NOT NULL,
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
  `b_id` INTEGER NOT NULL AUTO_INCREMENT,
  `f_id` INTEGER NOT NULL,
  `date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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
    `sex`           CHAR(1)    NOT NULL
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`golden_has_bills`
-- -----------------------------------------------------
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
        ON DELETE CASCADE 
        ON UPDATE CASCADE
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`bill_has_menu_item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`bill_has_menu_item`     -- No PK, but that is fine
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
-- Table `meatballs`.`facilityHours`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityHours` 
(
    `day`   VARCHAR(45) NULL,
    `open`  TIME NULL,
    `close` TIME NULL,
    PRIMARY KEY (day)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `meatballs`.`facilityStock`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`facilityStock` 
(
    `sku`       INTEGER NOT NULL,
    `f_id`      INTEGER NULL,
    `quantity`  INTEGER DEFAULT 0,
    PRIMARY KEY (`sku`, `f_id`),
    CONSTRAINT `fk_facilityStock_sku`
        FOREIGN KEY (`sku`) REFERENCES `meatballs`.`supplies` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    CONSTRAINT `fk_facilityStock_f_id`
        FOREIGN KEY (`f_id`) REFERENCES `meatballs`.`facility` (`f_id`)
        ON UPDATE CASCADE 
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `meatballs`.`order` 
(
    order_id    INTEGER PRIMARY KEY AUTO_INCREMENT,
    `f_id`      INTEGER NULL,
    `sku`       INTEGER NULL,
	`order_date`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `order_qty` INTEGER NULL,
    CONSTRAINT `fk_order_f_id`
        FOREIGN KEY (`f_id`) REFERENCES `meatballs`.`facility` (`f_id`) 
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    CONSTRAINT `fk_order_sku`
        FOREIGN KEY (`sku`) REFERENCES `meatballs`.`supplies` (`sku`)
        ON UPDATE CASCADE
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `meatballs`.`shift
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `meatballs`.`shift`
(
    -- shift_id        INTEGER PRIMARY KEY AUTO_INCREMENT,
    `staff_id`      INTEGER NOT NULL,
    `date`          DATE NOT NULL,
    `time_start`    TIME NOT NULL,
    `time_end`      TIME NOT NULL,
    `paid`          BOOLEAN NOT NULL, -- indicates whether or not they have been paid for this shift
    CONSTRAINT `fk_shift_staff_id`
        FOREIGN KEY (`staff_id`) REFERENCES `meatballs`.`staff` (`staff_id`)
        ON DELETE CASCADE,
    PRIMARY KEY (`staff_id`, `date`, `time_start`)
);

-- -----------------------------------------------------
-- Table `meatballs`.`facilityBalance
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `meatballs`.`facilityBalance`
(
     f_id        INTEGER NOT NULL PRIMARY KEY,
    `balance`    DECIMAL (15,2) NOT NULL DEFAULT 0.0,
    CONSTRAINT `fk_facilityBalance_f_id`
        FOREIGN KEY (`f_id`) 
        REFERENCES `meatballs`.`facility` (`f_id`)
);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
