use meatballs;
-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_balance_after_bill_log
-- 
-- PURPOSE : Log the updates made to the facilityBalance table
--
-- ---------------------------------------------------------
DROP TABLE IF EXISTS update_balance_after_bill_log;
CREATE TABLE IF NOT EXISTS update_balance_after_bill_log
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    b_id        INTEGER,
	mitem_id    INTEGER,
    msg         VARCHAR(255),
    f_id        INTEGER,
    balance_old     FLOAT,
    balance_new     FLOAT,
    price           FLOAT,
    FOREIGN KEY (`f_id`) REFERENCES `facilityBalance` (`f_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
	 FOREIGN KEY (`b_id`) REFERENCES `bill` (`b_id`)
			ON DELETE NO ACTION
			ON UPDATE CASCADE   
);
-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_stock_after_bill_log
-- 
-- PURPOSE : Log the updates made to the facilityStock table
--
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS update_stock_after_bill_log
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    f_id        INTEGER,
	mitem_id    INTEGER,
    b_id        INTEGER,
    msg         VARCHAR(255),
    FOREIGN KEY (`b_id`) REFERENCES `bill` (`b_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,   
    FOREIGN KEY (`f_id`) REFERENCES `facilityBalance` (`f_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TRIGGER : update_after_bill_trigger 
-- 
-- PURPOSE : update the facilityBalance the facilityStock
-- 			 quantity when a row is inserted in the 
--            `bill_has_menu_item` table.
--
-- ---------------------------------------------------------
DROP TRIGGER IF EXISTS update_after_bill_trigger;
DELIMITER $$$
CREATE TRIGGER update_after_bill_trigger
AFTER INSERT ON `bill_has_menu_item`
FOR EACH ROW
BEGIN
	-- 1. update `facilityBalance`
    set @location    = (SELECT f_id  FROM bill WHERE bill.b_id = NEW.b_id);
    SET @old_balance = (SELECT balance FROM facilityBalance WHERE f_id = @location);

    set @price = (SELECt price FROM  menu_item WHERE menu_item.mitem_id = NEW.mitem_id);

    INSERT INTO facilityBalance (f_id, balance)  
        VALUES (@location, @price)
        ON DUPLICATE KEY UPDATE balance = @old_balance + @price;

    -- 1.1 Log it in `update_balance_after_bill_log`
    SET @new_balance = (SELECT balance FROM facilityBalance WHERE f_id = @location);
    INSERT INTO update_balance_after_bill_log (msg, mitem_id, b_id, f_id, price, balance_old, balance_new)
        VALUES ("Update Balance after bill", NEW.b_id, NEW.mitem_id, @location, @price, @old_balance, @new_balance);


	
 	-- 1. update `facilityStock`

	SET SQL_SAFE_UPDATES=0;
	UPDATE facilityStock,
		(
			SELECT T2.f_id AS newF_ID, T1.sku, T2.quantity, T1.amount, (T2.quantity - T1.amount) AS newqty
			FROM (
					SELECT ingredients.sku, ingredients.amount
					FROM bill, menu_item NATURAL JOIN ingredients
					WHERE ingredients.mitem_id = NEW.mitem_id  AND  bill.b_id = NEW.b_id
				) AS T1, ( 
					SELECT facilityStock.f_id, facilityStock.sku, facilityStock.quantity
					FROM bill, ingredients NATURAL JOIN facilityStock
					WHERE ingredients.mitem_id = NEW.mitem_id AND bill.b_id = NEW.b_id
				) AS T2
			WHERE T1.sku = T2.sku
		) AS T3
	SET facilityStock.quantity = T3.newqty
	WHERE facilityStock.sku = T3.sku AND facilityStock.f_id = T3.newF_ID;
	SET SQL_SAFE_UPDATES=1;

 	-- 1.1 Log it in `update_balance_after_bill_log`
    INSERT INTO update_stock_after_bill_log (msg, f_id, mitem_id, b_id)
        VALUES ("Update Stock after bill", @location, NEW.mitem_id, NEW.b_id);

END; $$$
DELIMITER ;
