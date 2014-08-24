use meatballs;
INSERT INTO pay  (title, base, exp_rate, train_rate) VALUES
	('human resources', 40000,  5000, 0),
	('marketing',       40000,  5000, 0),
    ('manager',         80000,  1000, 0),
	('chef',            60000,  100,  1000),
    ('ceo',             500000, 5000, 0),
    ('cfo',             200000, 1000, 0),
    ('cto',             100000, 1000, 0);

INSERT INTO wage (title, base, exp_rate, overtime) VALUES
    ('cook',                17.50,  1.50,   1.25),
    ('dishwasher',          10.00,  1.50,   1.25),
    ('wait staff',          10.00,  0,      0),
    ('delivery personnel',  22.50,  0,      0)
    ('shift supervisor',    13.50,  0,      0);

