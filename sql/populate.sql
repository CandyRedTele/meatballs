--CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` (
--  `sku` INT NOT NULL,
--  `name` CHAR NULL,
--  `quantity` INT NULL,
--  `type` CHAR NULL,
--  PRIMARY KEY (`sku`))
--  ENGINE = InnoDB;

use meatballs;

insert into supplies
    (sku, name, quantity, type)
    values
		(13562, 'Meat Ball', 100,'Food'),
		(44365, 'Spaghetti', 20,'Food'),
		(13579, 'Tomato Sauce', 33,'Food'),
		(96298, 'Parsley', 20,'Food'),
		(32942, 'Tomato', 20,'Food'),
		(39650, 'Potato', 30,'Food'),
		(83883, 'Kimchi', 10,'Food'),
		(96259, 'Onion', 20,'Food'),
		(97628, 'Celery', 30,'Food'),
		(90142, 'Lemon', 30,'Food'),
		(82378, 'Stove', 5,'Food'),
		(17275, 'Oven', 5,'Kitchen Supplies'),
		(96538, 'Pan', 4,'Kitchen Supplies'),
		(67342, 'Knife', 20,'Kitchen Supplies'),
		(19616, 'Table', 3,'Kitchen Supplies'),
		(47840, 'Fork', 20,'Kitchen Supplies'),
		(12323, 'Tongs', 10,'Kitchen Supplies'),
		(43569, 'Meat Hammer', 2,'Kitchen Supplies'),
		(41733, 'Waffle Iron', 5,'Kitchen Supplies'),
		(62170, 'Plate', 100,'Serving Item'),
		(41091, 'Fork', 100,'Serving Item'),
		(74298, 'Spoon', 100,'Serving Item'),
		(29251, 'Knife', 100,'Serving Item'),
		(74622, 'Steak Knife', 50,'Serving Item'),
		(23784, 'Bowl', 40,'Serving Item'),
		(42878, 'Napkins', 100,'Serving Item'),
		(69525, 'Tray', 10,'Serving Item');


