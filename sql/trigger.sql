use `meatballs`;

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_stock_log_on_order
-- 
-- PURPOSE : Log the updates made to the facilityStock table
--
-- ---------------------------------------------------------
DROP TABLE IF EXISTS update_stock_log_on_order;
CREATE TABLE IF NOT EXISTS update_stock_log_on_order
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    order_id    INTEGER,
    msg         VARCHAR(255),
    sku         INTEGER,
    qty_new     INTEGER,
    qty_old     INTEGER,
    FOREIGN KEY (`sku`) REFERENCES `facilityStock` (`sku`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TABLE : update_balance_on_order
-- 
-- PURPOSE : Log the updates made to the facilityStock table
--
-- ---------------------------------------------------------
DROP TABLE IF EXISTS update_balance_on_order;
CREATE TABLE IF NOT EXISTS update_balance_on_order
(
    log_id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    order_id    INTEGER,
    msg         VARCHAR(255),
    f_id        INTEGER,
    new_balance     FLOAT,
    old_balance     FLOAT,
    price           FLOAT,
    quantity        INTEGER,
    FOREIGN KEY (`f_id`) REFERENCES `facilityBalance` (`f_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`)
        ON DELETE NO ACTION
        ON UPDATE CASCADE
);

-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++
-- 
-- TRIGGER : upd_stck_aft_insert_on_order_trigger 
-- 
-- PURPOSE : update the facilityStock quantity when a row
--           is inserted in the `order` table.
--
-- ---------------------------------------------------------
DROP TRIGGER IF EXISTS upd_stck_aft_insert_on_order_trigger;
DELIMITER $$$
CREATE TRIGGER upd_stck_aft_insert_on_order_trigger
AFTER INSERT ON `order`
FOR EACH ROW
BEGIN
    -- 1. update `facilityStock`
    SET @old_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku and f_id = NEW.f_id);

    IF (@old_qty IS NULL)  THEN
        SET @old_qty = 0;
    END IF;

    INSERT INTO facilityStock (sku, f_id, quantity) 
        VALUES (NEW.sku, NEW.f_id, NEW.order_qty)
        ON DUPLICATE KEY UPDATE quantity = @old_qty + NEW.order_qty;

    -- 1.1 Log it in `update_stock_log_on_order`
    SET @new_qty = (SELECT quantity FROM facilityStock WHERE sku = NEW.sku and f_id = NEW.f_id);
    INSERT INTO update_stock_log_on_order (msg, order_id, sku, qty_old, qty_new)
        VALUES ("Update Stock after order", NEW.order_id, NEW.sku, @old_qty, @new_qty); 

    -- 2. update `facilityBalance`
    SET @old_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
    SET @price      = (SELECT price from supplies WHERE sku = NEW.sku);

    INSERT INTO facilityBalance (f_id, balance)
        VALUES (NEW.f_id, (@price * NEW.order_qty))
        ON DUPLICATE KEY UPDATE balance = @old_balance + (@price * NEW.order_qty);

    -- 2.1 Log it in `update_balance_on_order`
    SET @new_balance = (SELECT balance FROM facilityBalance WHERE f_id = NEW.f_id);
    INSERT INTO update_balance_on_order (msg, order_id, f_id, old_balance, new_balance, price, quantity)
        VALUES ("Update balance after order", NEW.order_id, NEW.f_id, @old_balance, @new_balance, @price, NEW.order_qty); 

END; $$$
DELIMITER ;

