insert into localstaff (f_id, staff_id) values (1, 10);


#
# testing trigger : update_stock_trigger
#
select * from facilityStock where sku=99689;
INSERT INTO `order` (f_id, `sku`, order_date, order_qty) VALUES (1, 99087, '2000-01-01', 666);
select * from update_stock_log;
