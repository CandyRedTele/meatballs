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
