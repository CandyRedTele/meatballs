from urlparse import urlparse
from lxml import html
import requests
import json
from datetime import date, timedelta
from os.path import isfile
from random import randint, sample, uniform, randrange
from math import ceil

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
           'facility_balance': 'INSERT INTO facilityBalance (f_id, balance) VALUES'
          }


class Recipe():

    def __init__(self):
        pass

    def get_inserts(self):
        for tables in self.create_list():
            with open(tables[1] + '.sql', 'w') as f:
                s = "use meatballs;\n"
                s += inserts[tables[1]]
                for j, table in enumerate(tables[0]):
                    s += '\n('
                    s += self.helper_l_s(table)
                    s += ')'
                    if j == len(tables[0])-1:
                        s += ';'
                    else:
                        s += ','
                s += '\n'
                f.write(s.encode('ascii', 'ignore'))

    def helper_l_s(self, l):
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

    def create_dic(self):
        d = dict()
        if isfile('supply_menu.json'):
            with open('supply_menu.json', 'rb') as fp:
                d = json.load(fp)
        else:
            entree = self.getRecipe(entree_urls, min=8, max=16)
            main = self.getRecipe(main_urls, min=15, max=34)
            deserts = self.getRecipe(desert_urls, min=6, max=14)
            kids = self.getRecipe(kids_urls, min=8, max=15)
            d = {"deserts": deserts, "main": main,
                 "entree": entree, "kids": kids}
            d.update(wines)
            with open('supply_menu.json', 'w') as fp:
                json.dump(d, fp)
        return d

    def create_list(self):
        d = self.create_dic()

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

        supply = []
        for k in ingredients_name:
            supply.append([k[1], k[0], 'food', uniform(0.5, 13.9)])

        for i in other_supplies:
            supply.append(i)

        menu_item = []
        index = 1
        for category, i in d.iteritems():
            for name, j in i.iteritems():
                j.update({'id': index})
                menu_item.append([index, category, j['price'], name, j['image']])
                index += 1

        ingredients = [[j['id'], k[2], k[0]]
                       for i in d.itervalues()
                       for j in i.itervalues()
                       for k in j['ingredients']]

        food = []
        count = 0
        for category, i in d.iteritems():
            for j in i.itervalues():
                for k in j['ingredients']:
                    if (category == "wines" or count % 5 == 0):
                        k.append(randint(45, 500))
                        k.append(0)  # refers to false
                    else:
                        k.append(randint(5, 45))
                        k.append(1)  # refers to true
                    count += 1
                    food.append([k[2], 100, k[3], k[4]])

        menus_kind = [menu_item[i::17] for i in xrange(17)]

        common_menus = [item for sublist in menus_kind[12:]
                        for item in sublist]
        specific_menus = menus_kind[:12]
        for i in specific_menus:
            for j in common_menus:
                i.append(j)
        menu = []
        for i, j in enumerate(specific_menus, start=1):
            for k in j:
                menu.append([i, k[0]])

        wine_kind = [i[0] for i in menu_item if i[1] == 'wines']
        wine_rating = []
        for i in wine_kind:
            wine_rating.append([uniform(6.5, 10), i])

        skus = sample(range(50000, 99999), len(other_supplies))
        for i, j in enumerate(other_supplies):
            j.insert(0, skus[i])

        # `sku`       INTEGER NOT NULL,
        #  `f_id`      INTEGER NULL,
        #  `quantity`  INTEGER DEFAULT 0,
        # now = datetime.now().strftime('%Y-%m-%d')
        facility_stock = []
        ingre_menu_set = set()
        for j in menu:
            for k in ingredients:
                if j[1] == k[0]:
                    sku_ingre = k[1]
                    if sku_ingre not in ingre_menu_set:
                        ingre_menu_set.add(sku_ingre)
                        facility_stock.append([k[1], j[0], randint(15, 80)])

        #  order_id    INTEGER PRIMARY KEY AUTO_INCREMENT,
        #  `f_id`      INTEGER NULL,
        #  `sku`       INTEGER NULL,
        #  `order_date` DATE NOT NULL,
        #  `order_qty` INTEGER NULL,
        def inFList(l, i):
            return [x for x in l if x[1] == i]

        order = []
        for i in xrange(1, 13):
            ingre_per_f = inFList(facility_stock, i)
            for j in xrange(8):
                date_order = date.today()-timedelta(days=randrange(0,10))
                date_order = date_order.isoformat()
                pick = ingre_per_f[randint(0, len(ingre_per_f)-1)]
                order.append([pick[1], pick[0], date_order, (80 - pick[2])+1])


        vendor = []
        for i, j in enumerate(vendors, start=1):
            vendor.append([i, j[0], j[1]])
            j.insert(0, i)


        acatalog = []
        food_vendors = [ven for ven in vendors if ven[3] == 'food']

        for i in ingredients_name:
            x = randrange(0, len(food_vendors))
            acatalog.append([food_vendors[x][0], i[1]])

        linens_vendors = [ven for ven in vendors if ven[3] == 'linens']
        kitchen_vendors = [ven for ven in vendors if ven[3] == 'kitchen supplies']
        serving_vendors = [ven for ven in vendors if ven[3] == 'serving items']
        for i in other_supplies:
            if i[2] == 'linens':
                acatalog.append([linens_vendors[randrange(0, len(linens_vendors))][0], i[0]])
            elif i[2] == 'kitchen supplies':
                acatalog.append([kitchen_vendors[randrange(0, len(kitchen_vendors))][0], i[0]])
            elif i[2] == 'serving items':
                acatalog.append([serving_vendors[randrange(0, len(serving_vendors))][0], i[0]])

        #  facilityBalance
        # =================
        #  f_id        INTEGER NOT NULL PRIMARY KEY,
        # `balance`    INTEGER NOT NULL,
        facility_balance = []
        for f_id in xrange(1, 13):
                facility_balance.append([f_id, randint(1800, 2800)])

        return ((supply, 'supply'), (menu_item, 'menu_item'), (ingredients, 'ingredients'),
                (menu, 'menu'), (wine_rating, 'wine'), (food, 'food'), (facility_stock, 'facility_stock'),
                (vendor, 'vendor'), (acatalog, 'catalog'), (order, 'order'), (facility_balance, 'facility_balance'))

    def generateUrlRecipe(self, urls):
        newlist = []
        for i in urls:
            newlist.append(url + i)
        return newlist

    def getRecipe(self, urll, min, max):
        menu_category = {}
        urls = self.generateUrlRecipe(urll)
        for i in urls:
            response = requests.get(i).text
            tree = html.fromstring(response)
            menu = self.getMenu(tree, min, max)
            menu_category.update(menu)
        return menu_category

    def getMenu(self, tree, min, max):
        h = tree.xpath('//table[1]//tr[2]/td[2]')[0]
        l = urlparse(h.text)
        name = l.path.split('/')[2]
        image = tree.xpath('//table[1]//tr[5]/td[2]')[0].text
        table = tree.xpath('//table[2]')[0]
        amounts = []
        ingre_names = []

        for row in table[1:]:
            if not ingre_names.count(row[3].text.replace("'", "")):
                ingre_names.append(row[3].text.replace("'", ""))
                amounts.append([int(ceil(float(row[1].text))), row[3].text.replace("'", "")])
        price = randint(min, max)
        return {name: {'ingredients': amounts, 'price': price, 'image': image}}

other_supplies = [['Oven', 'kitchen supplies', 1000],
                  ['Pan', 'kitchen supplies', 50],
                  ['Knife', 'kitchen supplies', 5],
                  ['Table', 'kitchen supplies', 50],
                  ['Fork', 'kitchen supplies', 5],
                  ['Tongs', 'kitchen supplies', 5],
                  ['Meat Hammer', 'kitchen supplies', 60],
                  ['Waffle Iron', 'kitchen supplies', 50],
                  ['Plate', 'serving items', 5],
                  ['Fork', 'serving items', 5],
                  ['Spoon', 'serving items', 5],
                  ['Knife', 'serving items', 5],
                  ['Steak Knife', 'serving items', 6],
                  ['Bowl', 'serving items', 5],
                  ['Napkins', 'serving items', 1],
                  ['Tray', 'serving items', 4],
                  ['Table Clothes', 'linens', 15],
                  ['Aprons', 'linens', 6],
                  ['Fry Pans', 'kitchen supplies', 21],
                  ['Ingredient Bins', 'kitchen supplies', 10],
                  ['Sheet Pans', 'kitchen supplies', 50],
                  ['Roast Pan', 'kitchen supplies', 20],
                  ['Stock Pot', 'kitchen supplies', 80],
                  ['Deep Boiler', 'kitchen supplies', 60],
                  ['Pasta Cooker', 'kitchen supplies', 50],
                  ['Sauce Pot', 'kitchen supplies', 30],
                  ['Sauce Pan', 'kitchen supplies', 20],
                  ['Pizza Pan', 'kitchen supplies', 20],
                  ['Pizza Dough Boxes', 'kitchen supplies', 10],
                  ['Sheet Pan', 'kitchen supplies', 14],
                  ['Tongs', 'kitchen supplies', 12],
                  ['Disher', 'kitchen supplies', 10],
                  ['Ladle', 'kitchen supplies', 14],
                  ['Egg Slicer', 'kitchen supplies', 12],
                  ['Tapered Grater', 'kitchen supplies', 12],
                  ['Grill Cover', 'kitchen supplies', 21],
                  ['Steak Weight', 'kitchen supplies', 30],
                  ['Pancake Dispenser Stand', 'kitchen supplies', 30],
                  ['Dredge', 'kitchen supplies', 21],
                  ['Sandwich Spreader', 'kitchen supplies', 24],
                  ['Fish Turner', 'kitchen supplies', 21],
                  ['Cutting Board for Meat', 'kitchen supplies', 18],
                  ['Cutting Board for Fish', 'kitchen supplies', 18],
                  ['Cutting Board for Poultry', 'kitchen supplies', 18],
                  ['Knife Rack', 'kitchen supplies', 38],
                  ['Professional Cimeter', 'kitchen supplies', 50],
                  ['Cleaver', 'kitchen supplies', 21],
                  ['Sharpening Steel', 'kitchen supplies', 21],
                  ['Refrigerator/Freezer Thermometer', 'kitchen supplies', 43],
                  ['Can Opener', 'kitchen supplies', 15],
                  ['Nitrile Gloves', 'linens', 14],
                  ['Oven Mitt', 'linens', 16],
                  ['Cloth Pot Holder', 'linens', 18],
                  ['Digital Scale', 'kitchen supplies', 45],
                  ['Manual Slicer', 'kitchen supplies', 90],
                  ['Table Skirting', 'linens', 60],
                  ['Vinyl Tablecloth', 'linens', 20],
                  ['Salt and Pepper Shaker', 'serving items', 10],
                  ['Single Jacket Menu', 'serving items', 17],
                  ['Menu Holder', 'serving items', 10],
                  ['Tabletop Sign Holder', 'serving items', 10],
                  ['Table Top Napkin Holders', 'serving items', 8],
                  ['Napkins', 'serving items', 1],
                  ['Straw Dispenser', 'serving items', 10],
                  ['Straw', 'serving items', 1],
                  ['Cone Holder', 'serving items', 12],
                  ['Countertop Organizer', 'serving items', 45],
                  ['Beverage Dispenser', 'serving items', 120],
                  ['Tea Urn', 'serving items', 80],
                  ['Coffee Maker', 'serving items', 140],
                  ['Espresso Maker', 'serving items', 180],
                  ['Panini Grill', 'kitchen supplies', 70],
                  ['Rice Cooker/Warmer', 'kitchen supplies', 90],
                  ['Filter Drain Pot', 'kitchen supplies', 40],
                  ['Bottle Cooler', 'kitchen supplies', 30],
                  ['Overhead Glass Rack', 'kitchen supplies', 40],
                  ['Ice bin', 'kitchen supplies', 90],
                  ['Champagne Bucket and Stand', 'serving items', 20],
                  ['Waiter Corkscrew', 'serving items', 10],
                  ['Glass Storage Rack', 'kitchen supplies', 12],
                  ['Sink', 'kitchen supplies', 300],
                  ['Drainboards', 'kitchen supplies', 200],
                  ['Refrigerator', 'kitchen supplies', 1200],
                  ['Freezer', 'kitchen supplies', 1300],
                  ['Chairs', 'serving items', 40]]

vendors = [['Servu-online', '3201 Apollo Drive Champaign, IL', 'kitchen supplies'], ['PA Supermarche', '1420 Rue du Fort Montreal, QC', 'food'],
           ['Provigo', '3421 Avenue du Parc Montreal, QC', 'food'], ['Segals Market', '4001 Boulevard Saint-Laurent Montreal, QC', 'food'],
           ['Super C', '147 Avenue Atwater Montreal, QC', 'food'], ['Lucky', '4527 8 Ave SE, Calgary, AB', 'food'],
           ['Island Market', '1502 W 2nd Ave #120, Vancouver, BC', 'food'], ['Stong Markets', '4560 Dunbar St, Vancouver, BC', 'food'],
           ['Mikasa', '4450 Rochdale Blvd Regina, SK', 'serving items'], ['George Courey', '326 Victoria Ave Westmount, QC', 'linens']]

url = "http://hangryingreedytest.herokuapp.com/?recipe_url="
main_urls = [
    'http://allrecipes.com/Recipe/Worlds-Best-Lasagna/Detail.aspx?evt19=1',
    "http://allrecipes.com/Recipe/Bacon-Roasted-Chicken-with-Potatoes/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Hot-Tamale-Pie/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Aussie-Chicken/",
    "http://allrecipes.com/Recipe/Yummy-Honey-Chicken-Kabobs/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Apple-Butter-Pork-Loin/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Lime-Chicken-Soft-Tacos/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Sloppy-Joes-II/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Boilermaker-Tailgate-Chili/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Easy-Meatloaf/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Grilled-Salmon-I/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Maple-Salmon/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Famous-Butter-Chicken/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Heathers-Fried-Chicken/",
    "http://allrecipes.com/Recipe/Chicken-Breasts-with-Balsamic-Vinegar-and-Garlic/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Eggplant-Parmesan-II/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Braised-Balsamic-Chicken/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Italian-Chicken-Marinade/Detail.aspx?evt19=1"]
desert_urls = [
    'http://allrecipes.com/Recipe/Chicken-Pot-Pie-IX/Detail.aspx?evt19=1',
    "http://allrecipes.com/Recipe/Best-Brownies/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Chantals-New-York-Cheesecake/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Cream-Cheese-Frosting-II/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Aunt-Teens-Creamy-Chocolate-Fudge/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Basic-Crepes/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Golden-Rum-Cake/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Old-Fashioned-Coconut-Cream-Pie/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Chocolate-Ganache/",
    "http://allrecipes.com/Recipe/Best-Carrot-Cake-Ever/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Flourless-Chocolate-Cake-I/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Rolled-Buttercream-Fondant/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Fruit-Pizza-I/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Black-Bean-Brownies/Detail.aspx?evt19=1"]
entree_urls = [
    'http://allrecipes.com/Recipe/Mexican-Bean-Salad/Detail.aspx?evt19=1',
    "http://allrecipes.com/Recipe/Roquefort-Pear-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Red-Skinned-Potato-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Barbies-Tuna-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Holiday-Chicken-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Alysons-Broccoli-Salad-2/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Judys-Strawberry-Pretzel-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Classic-Macaroni-Salad/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Hummus-III/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Baked-Kale-Chips/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Delicious-Ham-and-Potato-Soup/",
    "http://allrecipes.com/Recipe/Slow-Cooker-Chicken-and-Dumplings/",
    "http://allrecipes.com/Recipe/Strawberry-Spinach-Salad-I/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/King-Crab-Appetizers/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Cocktail-Meatballs/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Jet-Swirl-Pizza-Appetizers/Detail.aspx?evt19=1"]
kids_urls = [
    "http://allrecipes.com/Recipe/Tuna-Noodle-Casserole-from-Scratch/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/EZ-Pizza-for-Kids/",
    "http://allrecipes.com/Recipe/Bacon-Wrapped-Smokies/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Homemade-Mac-and-Cheese/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Baked-Ziti-I/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Spinach-Quiche-with-Kid-Appeal/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Millys-Oatmeal-Brownies/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Cajun-Grilled-Corn/",
    "http://allrecipes.com/Recipe/Best-Baked-French-Fries/Detail.aspx?evt19=1",
    "http://allrecipes.com/Recipe/Creamy-Hot-Chocolate/Detail.aspx?evt19=1"]

wines = {
        'wines': {'Cune Rioja Imperial Gran Reserva': {'ingredients': [[1.0, 'Cune Rioja Imperial Gran Reserva']], 'price': 63, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau Canon-La Gaffeliere St.-Emilion': {'ingredients': [[1.0, 'Chateau Canon-La Gaffeliere St.-Emilion']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve': {'ingredients': [[1.0, 'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve']], 'price': 20, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Hewitt Cabernet Sauvignon Rutherford': {'ingredients': [[1.0, 'Hewitt Cabernet Sauvignon Rutherford']], 'price': 29, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Kongsgaard Chardonnay Napa Valley': {'ingredients': [[1.0, 'Kongsgaard Chardonnay Napa Valley']], 'price': 27, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Giuseppe Mascarello & Figlio Barolo Monprivato': {'ingredients': [[1.0, 'Giuseppe Mascarello & Figlio Barolo Monprivato']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee': {'ingredients': [[1.0, 'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau de Beaucastel Chateauneuf-du-Pape': {'ingredients': [[1.0, 'Chateau de Beaucastel Chateauneuf-du-Pape']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Lewis Cabernet Sauvignon Napa Valley Reserve': {'ingredients': [[1.0, 'Lewis Cabernet Sauvignon Napa Valley Reserve']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Quilceda Creek Cabernet Sauvignon Columbia Valley': {'ingredients': [[1.0, 'Quilceda Creek Cabernet Sauvignon Columbia Valley']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Reynvaan Syrah Walla Walla Valley Stonessence': {'ingredients': [[1.0, 'Reynvaan Syrah Walla Walla Valley Stonessence']], 'price': 27, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Turley Zinfandel Paso Robles Dusi Vineyard': {'ingredients': [[1.0, 'Turley Zinfandel Paso Robles Dusi Vineyard']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Croft Vintage Port': {'ingredients': [[1.0, 'Croft Vintage Port']], 'price': 29, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Bedrock The Bedrock Heritage Sonoma Valley': {'ingredients': [[1.0, 'Bedrock The Bedrock Heritage Sonoma Valley']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Olivier Ravoire Gigondas': {'ingredients': [[1.0, 'Olivier Ravoire Gigondas']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'G.D. Vajra Barolo Albe': {'ingredients': [[1.0, 'G.D. Vajra Barolo Albe']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Alexana Pinot Noir Dundee Hills Revana Vineyard': {'ingredients': [[1.0, 'Alexana Pinot Noir Dundee Hills Revana Vineyard']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Poggerino Chianti Classico': {'ingredients': [[1.0, 'Poggerino Chianti Classico']], 'price': 22, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Hamilton Russell Chardonnay Hemel-en-Aarde Valley': {'ingredients': [[1.0, 'Hamilton Russell Chardonnay Hemel-en-Aarde Valley']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau Dereszla Tokaji Aszu 5 Puttonyos': {'ingredients': [[1.0, 'Chateau Dereszla Tokaji Aszu 5 Puttonyos']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Le Macchiole Bolgheri': {'ingredients': [[1.0, 'Le Macchiole Bolgheri']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'La Rioja Alta Rioja Vina Ardanza Reserva': {'ingredients': [[1.0, 'La Rioja Alta Rioja Vina Ardanza Reserva']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Seghesio Zinfandel Dry Creek Valley Cortina': {'ingredients': [[1.0, 'Seghesio Zinfandel Dry Creek Valley Cortina']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Livio Sassetti Brunello di Montalcino Pertimali': {'ingredients': [[1.0, 'Livio Sassetti Brunello di Montalcino Pertimali']], 'price': 25, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Epoch Estate Blend Paderewski Vineyard Paso Robles': {'ingredients': [[1.0, 'Epoch Estate Blend Paderewski Vineyard Paso Robles']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Alvaro Palacios Priorat Les Terrasses Velles Vinyes': {'ingredients': [[1.0, 'Alvaro Palacios Priorat Les Terrasses Velles Vinyes']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Spring Valley Uriah Walla Walla Valley': {'ingredients': [[1.0, 'Spring Valley Uriah Walla Walla Valley']], 'price': 25, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana': {'ingredients': [[1.0, 'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana']], 'price': 19, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'}}}
