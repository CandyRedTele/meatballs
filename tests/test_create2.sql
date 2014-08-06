use project;
drop table if EXISTS `staff`;
drop table if exists `local`;

-- -----------------------------------------------------
-- Table `project`.`staff`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `project`.`staff` 
(
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
CREATE TABLE IF NOT EXISTS `local` 
(
  id INT,
  title VARCHAR(45) NULL,
  FOREIGN KEY (`id`) REFERENCES staff (id)
)
ENGINE = InnoDB;
