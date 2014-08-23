use strict;
use warnings;

my $file = "sql/supply_menu/bill.sql";



my $match='(\d{4}-\d{2}-\d{2})';

$^I = '.bak';
while (<>) {
    s/$match/$1 12:00:00/g;
    print;
}

