import sys
import json
from datetime import datetime, date, time, timedelta
from os.path import isfile
from random import randint, sample, uniform, randrange
from data_recipe import create_dic, dataRecipe

inserts = {'supply': 'INSERT INTO supplies (sku, name, type, price) VALUES',
           'menu_item': 'INSERT INTO menu_item (mitem_id, category, price, name, image) VALUES',
           'ingredients': 'INSERT INTO ingredients (mitem_id, sku, amount) VALUES',
           'menu': 'INSERT INTO menu (m_id, mitem_id) VALUES',
           'wine': 'INSERT INTO wine (rate, mitem_id) VALUES',
           'food': 'INSERT INTO food (sku, capacity, days_till_expired, perishable) VALUES',
           'facility_stock': 'INSERT INTO facilityStock (sku, f_id, quantity) VALUES',
           'vendor': 'INSERT INTO vendor (vendor_id, company_name, address) VALUES',
           'catalog': 'INSERT INTO catalog (vendor_id, sku) VALUES',
           'order': 'INSERT INTO `order` (f_id, sku, order_date, order_qty) VALUES',
           'facility_balance': 'INSERT INTO facilityBalance (f_id, balance) VALUES',
           'bill': 'INSERT INTO bill (b_id, f_id, `date`) VALUES',
           'bill_has_menu_item': 'INSERT INTO bill_has_menu_item (b_id, mitem_id) VALUES',
           'golden_has_bills': 'INSERT INTO golden_has_bills (g_id, b_id) VALUES'
          }


def get_inserts():
    """ Generates all the sql files with the insert statements """
    all_tables = create_list()
    for tables in all_tables:
        with open(tables[1] + '.sql', 'w') as f:
            s = "use meatballs;\n"
            s += inserts[tables[1]]
            for j, table in enumerate(tables[0]):
                s += '\n('
                s += helper_list_string(table)
                s += ')'
                if j == (len(tables[0]) - 1):
                    s += ';'
                else:
                    s += ','
            s += '\n'
            f.write(s.encode('ascii', 'ignore'))

def helper_list_string(l):
    """ Helper function to transform lists in a sql string """
    s = ""
    for i in l:
        if isinstance(i, basestring):
            s += "'"
            s += i
            s += "'"
        else:
            s += str(i)
        s += ', '
    return s[:-2]

def get_dic():
    """ First step in processus, gets all the data required """
    d = dict()
    if isfile('supply_menu.json'):
        with open('supply_menu.json', 'rb') as fp:
            d = json.load(fp)
    else:
        d = create_dic()
    return d

def create_list():
    """ Get list of list needed for the sql scripts """
    # External Data
    dataR = dataRecipe()
    other_supplies = dataR.other_supplies
    vendors = dataR.vendors

    d = get_dic()

    ingredients_name = [k[1] for i in d.itervalues()
          for j in i.itervalues() for k in j['ingredients']]

    ingredients_name_set = []
    [ingredients_name_set.append(i) for i in ingredients_name if not ingredients_name_set.count(i)]

    skus = sample(range(10000, 49999), len(ingredients_name_set))
    ingredients_name = []
    for i, j in enumerate(ingredients_name_set):
        ingredients_name.append((j, skus[i]))

    ingredients_name_dict = dict(ingredients_name)

    for i in d.itervalues():
        for j in i.itervalues():
            for k in j['ingredients']:
                k.append(ingredients_name_dict[k[1]])

    # supply
    # ========
    # `sku`     INTEGER NOT NULL,
    # `name`    VARCHAR(85) NULL,
    # `type`    VARCHAR(45) NULL,
    # `price`   DOUBLE NULL,
    supply = []
    for k in ingredients_name:
        supply.append([k[1], k[0], 'food', uniform(0.5, 13.9)])
    for i in other_supplies:
        supply.append(i)

    # menu_item
    # ==========
    # `mitem_id` INTEGER PRIMARY KEY AUTO_INCREMENT,
    # `category` CHAR(45) NULL,
    # `price` DOUBLE NULL,
    # `name` VARCHAR(65) NULL,
    # `image` VARCHAR(95) NULL
    menu_item = []
    index = 1
    for category, i in d.iteritems():
        for name, j in i.iteritems():
            j.update({'id': index})
            menu_item.append([index, category, j['price'], name, j['image']])
            index += 1

    # ingredients
    # ============
    # `mitem_id`   INTEGER REFERENCES meatballs.menu_item (mitem_id),
    # `sku`       INTEGER REFERENCES meatballs.ingredients (sku),
    # `amount`    VARCHAR(30) NULL,
    ingredients = [[j['id'], k[2], k[0]]
                   for i in d.itervalues()
                   for j in i.itervalues()
                   for k in j['ingredients']]

    # food
    # =====
    # `sku` INTEGER NOT NULL,
    # `capacity`  INTEGER  NOT NULL,
    # `days_till_expired` INT NOT NULL,
    # `perishable` BOOLEAN NULL,
    food = []
    count = 0
    for category, i in d.iteritems():
        for j in i.itervalues():
            for k in j['ingredients']:
                if (category == "wines" or count % 5 == 0):
                    k.append(randint(45, 500))
                    k.append(0)  # refers to false
                else:
                    k.append(randint(6, 45))
                    k.append(1)  # refers to true
                count += 1
                food.append([k[2], 1000, k[3], k[4]])

    # menu
    # ======
    # `m_id` INTEGER NOT NULL,
    # `mitem_id` INTEGER NOT NULL,
    def find_skus_fa(di, a):
        for i in di.itervalues():
            for j in i.itervalues():
                if j['id'] == a:
                    x = []
                    for k in j['ingredients']:
                        x.append(k[2])
        return x

    menus_kind = [menu_item[i::17] for i in xrange(17)]

    common_menus = [item for sublist in menus_kind[12:]
                    for item in sublist]
    specific_menus = menus_kind[:12]
    for i in specific_menus:
        for j in common_menus:
            i.append(j)

    menu = []
    sku_per_facility = [[] for i in range(len(specific_menus))]
    for i, j in enumerate(specific_menus, start=1):
        for k in j:
            menu.append([i, k[0]])
            skus_ingre = find_skus_fa(d, k[0])
            for sku_ingre in skus_ingre:
                if sku_ingre not in sku_per_facility[i - 1]:
                    sku_per_facility[i - 1].append(sku_ingre)

    # facility_stock
    # ==============
    # `sku`       INTEGER NOT NULL,
    #  `f_id`      INTEGER NULL,
    #  `quantity`  INTEGER DEFAULT 0,
    # Add other_supplies to facilityStock
    skus = sample(range(50000, 99999), len(other_supplies))
    for i, j in enumerate(other_supplies):
        j.insert(0, skus[i])

    facility_stock = []
    for i in xrange(12):
        for j in other_supplies:
            facility_stock.append([j[0], (i+1), randint(1, 8)])

    # order
    # =======
    #  order_id    INTEGER PRIMARY KEY AUTO_INCREMENT,
    #  `f_id`      INTEGER NULL,
    #  `sku`       INTEGER NULL,
    #  `order_date` DATE NOT NULL,
    #  `order_qty` INTEGER NULL,
    order = []
    for i, fa in enumerate(sku_per_facility):
        for sk in fa:
            date_order = date.today()-timedelta(days=randrange(0,7))
            date_order = date_order.isoformat()
            order.append([(i+1), sk, date_order, randint(700, 1000)])
            count = count + 1

    # bill
    # ====
    # `b_id` INTEGER NOT NULL AUTO_INCREMENT,
    # `f_id` INTEGER NOT NULL,
    # `date` DATE NOT NULL,

    # golden_has_bills
    # ================
    # `g_id`    INTEGER NOT NULL,
    # `b_id`    INTEGER PRIMARY KEY,

    # generate 120 bills.
    bill_len = 120
    # we have 30 golden menbers
    golden_members = 30

    bill = []
    golden_has_bills = []
    for i in xrange(bill_len):
        d_date = date.today() - timedelta(days=randrange(0, 6))
        d_time = time(randrange(11, 23), randrange(0, 59, 15))
        date_bill = datetime.combine(d_date, d_time)
        date_bill = date_bill.isoformat()
        bill.append([(i + 1), randint(1, 12), date_bill])
        if (i % 3) == 0:
            golden_has_bills.append([randint(1, golden_members), (i + 1)])

    # bill_has_menu_item
    # ===================
    # `b_id`        INTEGER NOT NULL,
    # `mitem_id`    INTEGER NOT NULL,
    def find_in_menu(l, a):
        j = []
        for x in l:
            if x[0] == a:
                j.append(x[1])
        return j

    bill_has_menu_item = []
    for i, bil in enumerate(bill, start=1):
        poss = find_in_menu(menu, bil[1])
        samp = sample(poss, 6)
        for ss in samp:
            bill_has_menu_item.append([i, ss])

    # wine
    # =====
    # `rate` DOUBLE NULL,
    # `mitem_id` INTEGER NULL,
    # PRIMARY KEY (mitem_id),
    wine_kind = [i[0] for i in menu_item if i[1] == 'wines']
    wine_rating = []
    for i in wine_kind:
        wine_rating.append([uniform(6.5, 10), i])

    # vendor
    # ========
    # `vendor_id`     INTEGER PRIMARY KEY,
    # `company_name`  VARCHAR(45) NULL,
    # `address`       VARCHAR(45) NULL
    vendor = []
    for i, j in enumerate(vendors, start=1):
        vendor.append([i, j[0], j[1]])
        j.insert(0, i)

    # catalog
    # =========
    # `vendor_id`     INTEGER NOT NULL REFERENCES meatballs.vendor (vendor_id),
    # `sku`           INTEGER NOT NULL REFERENCES meatballs.supplies (sku),
    acatalog = []
    food_vendors = [ven for ven in vendors if ven[3] == 'food']

    for i in ingredients_name:
        x = randrange(0, len(food_vendors))
        acatalog.append([food_vendors[x][0], i[1]])

    linens_vendors = [ven for ven in vendors if ven[3] == 'linens']
    kitchen_vendors = [ven for ven in vendors if ven[3] == 'kitchen supplies']
    serving_vendors = [ven for ven in vendors if ven[3] == 'service items']
    for i in other_supplies:
        if i[2] == 'linens':
            acatalog.append([linens_vendors[randrange(0,
                                            len(linens_vendors))][0], i[0]])
        elif i[2] == 'kitchen supplies':
            acatalog.append([kitchen_vendors[randrange(0,
                                             len(kitchen_vendors))][0], i[0]])
        elif i[2] == 'service items':
            acatalog.append([serving_vendors[randrange(0,
                                             len(serving_vendors))][0], i[0]])

    #  facilityBalance
    # =================
    #  f_id        INTEGER NOT NULL PRIMARY KEY,
    # `balance`    INTEGER NOT NULL,
    facility_balance = []
    for f_id in xrange(1, 13):
        facility_balance.append([f_id, randint(920000, 1100000)])

    return ((supply, 'supply'), (menu_item, 'menu_item'),
            (ingredients, 'ingredients'), (menu, 'menu'),
            (wine_rating, 'wine'), (food, 'food'),
            (facility_stock, 'facility_stock'), (vendor, 'vendor'),
            (acatalog, 'catalog'), (order, 'order'),
            (facility_balance, 'facility_balance'), (bill, 'bill'),
            (bill_has_menu_item, 'bill_has_menu_item'),
            (golden_has_bills, 'golden_has_bills'))


if __name__ == "__main__":
    sys.exit(get_inserts())

