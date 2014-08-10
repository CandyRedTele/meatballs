use meatballs;

# 
# TABLE : pay       TODO generate values - those are just to be able to test!!!
#
INSERT INTO pay  (title, base, exp_rate, train_rate) VALUES
	('Cook', 20000, 1.25, 1.1),
	('Exec1', 20000, 1.25, 1.1),
	('Exec2', 20000, 1.25, 1.1)
;

#
# TABLE : supplies
#
insert into supplies (sku, name, type) values
		(91463, 'Meat Ball', 'Food'),
		(57417, 'Spaghetti', 'Food'),
		(24143, 'Tomato Sauce', 'Food'),
		(44775, 'Parsley', 'Food'),
		(47256, 'Tomato', 'Food'),
		(52525, 'Potato', 'Food'),
		(80615, 'Kimchi', 'Food'),
		(75155, 'Onion', 'Food'),
		(67616, 'Celery', 'Food'),
		(84659, 'Lemon', 'Food'),
		(21622, 'Stove', 'Food'),
		(50021, 'Oven', 'Kitchen Supplies'),
		(52959, 'Pan', 'Kitchen Supplies'),
		(56686, 'Knife', 'Kitchen Supplies'),
		(81906, 'Table', 'Kitchen Supplies'),
		(72301, 'Fork', 'Kitchen Supplies'),
		(66137, 'Tongs', 'Kitchen Supplies'),
		(53286, 'Meat Hammer', 'Kitchen Supplies'),
		(83199, 'Waffle Iron', 'Kitchen Supplies'),
		(37587, 'Plate', 'Serving Items'),
		(31199, 'Fork', 'Serving Items'),
		(98124, 'Spoon', 'Serving Items'),
		(37509, 'Knife', 'Serving Items'),
		(38371, 'Steak Knife', 'Serving Items'),
		(94184, 'Bowl', 'Serving Items'),
		(51153, 'Napkins', 'Serving Items'),
		(34872, 'Tray', 'Serving Items'),
		(67513, 'Table Clothes', 'Linens'),
		(96072, 'Aprons', 'Linens');
