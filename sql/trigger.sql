use `meatballs`;

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_stock_log
-- 
-- PURPOSE : Log the updates made to the facilityStock table
--
-- ---------------------------------------------------------
DROP TABLE IF EXISTS update_stock_log;
CREATE TABLE IF NOT EXISTS update_stock_log
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    msg         VARCHAR(255),
    sku         INTEGER,
    qty_new     INTEGER,
    qty_old     INTEGER,
    FOREIGN KEY (`sku`) REFERENCES `facilityStock` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_balance_log
-- 
-- PURPOSE : Log the updates made to the facilityStock table
--
-- ---------------------------------------------------------
DROP TABLE IF EXISTS update_balance_log;
CREATE TABLE IF NOT EXISTS update_balance_log
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    msg         VARCHAR(255),
    f_id        INTEGER,
    new_balance     INTEGER,
    old_balance     INTEGER,
    price           INTEGER,
    FOREIGN KEY (`f_id`) REFERENCES `facilityBalance` (`f_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TRIGGER : update_stock_trigger 
-- 
-- PURPOSE : update the facilityStock quantity when a row
--           is inserted in the `order` table.
--
-- ---------------------------------------------------------
DROP TRIGGER IF EXISTS update_stock_trigger;
DELIMITER $$$
CREATE TRIGGER update_stock_trigger
AFTER INSERT ON `order`
FOR EACH ROW
BEGIN
    -- 1. update `facilityStock`
    SET @old_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku);

    INSERT INTO facilityStock (sku, f_id, quantity) 
        VALUES (NEW.sku, NEW.f_id, NEW.order_qty)
        ON DUPLICATE KEY UPDATE quantity = @old_qty + NEW.order_qty;

    -- 1.1 Log it in `update_stock_log`
    SET @new_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku);
    INSERT INTO update_stock_log (msg, sku, qty_old, qty_new)
        VALUES ("Update Stock after order", NEW.sku, @old_qty, @new_qty); 

    -- 2. update `facilityBalance`
    SET @old_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
    SET @price      = (SELECT price from supplies WHERE sku = NEW.sku);

    INSERT INTO facilityBalance (f_id, balance)
        VALUES (NEW.f_id, @price * NEW.order_qty)
        ON DUPLICATE KEY UPDATE balance = @old_balance + (@price * NEW.order_qty);

    -- 2.1 Log it in `update_balance_log`
    SET @new_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
    INSERT INTO update_balance_log (msg, f_id, old_balance, new_balance, price)
        VALUES ("Update balance after order", NEW.f_id, @old_balance, @new_balance, @price); 

END; $$$
DELIMITER ;

