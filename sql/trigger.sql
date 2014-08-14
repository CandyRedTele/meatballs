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
    SET @old_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku);
    INSERT INTO facilityStock (sku, f_id, quantity) 
        VALUES (NEW.sku, NEW.f_id, NEW.order_qty)
        ON DUPLICATE KEY UPDATE quantity = @old_qty + NEW.order_qty;

    SET @new_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku);

    INSERT INTO update_stock_log (msg, sku, qty_old, qty_new)
        VALUES ("Update Stock after order", NEW.sku, @old_qty, @new_qty); 
END; $$$
DELIMITER ;

# Attempt to create a trigger to remove money from the facility's balance but
# MySql do not support more then one trigger of the same type on the same table.

-- DROP TRIGGER IF EXISTS update_balance_on_order_trigger;
-- DELIMITER $$$
-- CREATE TRIGGER update_balance_on_order_trigger
-- AFTER INSERT ON `order`
-- FOR EACH ROW
-- BEGIN
--     SET @old_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
-- 
--     SET @price = (SELECT supplies.price FROM supplies WHERE supplies.sku = NEW.sku);
-- 	
--     UPDATE facilityBalance
--     SET balance = @old_balance - @price
--     WHERE f_id = NEW.f_id;
-- 
--     SET @new_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
-- 
--     INSERT INTO update_balance_log (msg, f_id, balance_old, balance_new)
--         VALUES ("Update Balance after order", NEW.f_id, @old_balance, @new_balance); 
-- END; $$$
-- DELIMITER ;