
insert into access_level (title, access_level) values ('cook', 4);

#
# testing trigger : update_stock_trigger
#
select * from facilityStock where sku=99689;
insert into `order` (f_id, sku, order_qty) values (1, 99689, 666);
select * from update_stock_log;
>>>>>>> master
