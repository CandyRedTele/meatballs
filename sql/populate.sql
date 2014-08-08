--#CREATE TABLE IF NOT EXISTS `meatballs`.`supplies` (
--#  `sku` INT NOT NULL,
--#  `name` CHAR NULL,
--#  `quantity` INT NULL,
--#  `type` CHAR NULL,
--#  PRIMARY KEY (`sku`))
--#  ENGINE = InnoDB;

use meatballs;

insert into supplies
    (sku, name, quantity, type)
    values
		(91463, 'Meat Ball', 100, 'Food'),
		(57417, 'Spaghetti', 20, 'Food'),
		(24143, 'Tomato Sauce', 33, 'Food'),
		(44775, 'Parsley', 20, 'Food'),
		(47256, 'Tomato', 20, 'Food'),
		(52525, 'Potato', 30, 'Food'),
		(80615, 'Kimchi', 10, 'Food'),
		(75155, 'Onion', 20, 'Food'),
		(67616, 'Celery', 30, 'Food'),
		(84659, 'Lemon', 30, 'Food'),
		(21622, 'Stove', 5, 'Food'),
		(50021, 'Oven', 5, 'Kitchen Supplies'),
		(52959, 'Pan', 4, 'Kitchen Supplies'),
		(56686, 'Knife', 20, 'Kitchen Supplies'),
		(81906, 'Table', 3, 'Kitchen Supplies'),
		(72301, 'Fork', 20, 'Kitchen Supplies'),
		(66137, 'Tongs', 10, 'Kitchen Supplies'),
		(53286, 'Meat Hammer', 2, 'Kitchen Supplies'),
		(83199, 'Waffle Iron', 5, 'Kitchen Supplies'),
		(37587, 'Plate', 100, 'Serving Items'),
		(31199, 'Fork', 100, 'Serving Items'),
		(98124, 'Spoon', 100, 'Serving Items'),
		(37509, 'Knife', 100, 'Serving Items'),
		(38371, 'Steak Knife', 50, 'Serving Items'),
		(94184, 'Bowl', 40, 'Serving Items'),
		(51153, 'Napkins', 100, 'Serving Items'),
		(34872, 'Tray', 10, 'Serving Items'),
		(67513, 'Table Clothes', 50, 'Linens'),
		(96072, 'Aprons', 20, 'Linens');

