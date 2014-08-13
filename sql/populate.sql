source create_table.sql;
source staff/pay.sql;
source staff/staffgen.sql;
source staff/gen_admin.sql;
source supply_menu/supply_menu.sql;

source facility/gen_facility.sql;

source staff/gen_localStaff.sql;

source facility/gen_facilityHours.sql;
source supply_menu/facility_stock.sql;      # this one needs the facility table to be created before

source bills/gen_bills.sql;
source bills/gen_bill_has_items.sql;
