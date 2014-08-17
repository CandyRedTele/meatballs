
insert into access_level (title, access_level) values ('cook', 4);

#
# testing trigger : update_stock_trigger
#
select * from facilityStock where sku=99689;
INSERT INTO `order` (f_id, `sku`, order_date, order_qty) VALUES (1, 99087, '2000-01-01', 666);
select * from update_stock_log;
>>>>>>> master
