from urlparse import urlparse
from lxml import html
import requests
import json
import datetime
from os.path import isfile
from random import randint, sample, uniform

inserts = {'supply': 'INSERT INTO supplies (sku, name, type) VALUES (',
           'menu_item': 'INSERT INTO menu_item (mitem_id, category, price, name) VALUES (',
           'ingredients': 'INSERT INTO ingredients (sku, mitem_id, amount) VALUES (',
           'menu': 'INSERT INTO menu (m_id, mitem_id) VALUES (',
           'wine': 'INSERT INTO wine (rate, mitem_id) VALUES (',
           'food': 'INSERT INTO food (sku, capacity, days_till_expired, perishable) VALUES (',
           'facility_stock': 'INSERT INTO facilityStock (quantity, order_date, sku, f_id) VALUES ('}


class Recipe():

    def __init__(self):
        pass
        #self.supply, self.menu_item, self.ingredient, self.menu, self.wine, self.other_supply, self.food = self.create_list()

    def get_inserts(self):
        for tables in self.create_list():
            with open(tables[1] + '.sql', 'w') as f:
                s = "use meatballs; "
                for i in tables[0]:
                    s += inserts[tables[1]]
                    s += self.helper_l_s(i)
                    s += '); '
                f.write(s.encode('ascii','ignore'))


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
        return d

    def create_list(self):
        d = self.create_dic()

        skus_items = [k for i in d.itervalues()
                      for j in i.itervalues() for k in j['ingredients']]
        skus = sample(range(10000, 49999), len(skus_items))
        supply = []
        index = 0
        for i in d.itervalues():
            for j in i.itervalues():
                for k in j['ingredients']:
                    k.append(skus[index])
                    index += 1
                    supply.append([k[2], k[1], 'food'])

        menu_item = []
        index = 1
        for category, i in d.iteritems():
            for name, j in i.iteritems():
                j.update({'id': index})
                menu_item.append([index, category, j['price'], name])
                index += 1

        ingredients = [[k[2], j['id'], k[0]]
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
                        k.append(0) # refers to false
                    else:
                        k.append(randint(5, 45))
                        k.append(1) # refers to true
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

        supplies = supply + other_supplies

        now = datetime.datetime.now().strftime('%Y-%m-%d')
        facility_stock = []
        for j in menu:  
            for k in ingredients:
                if j[1] == k[1]:
                    facility_stock.append([randint(5, 100), now, k[0], j[0]])

        return ((supplies, 'supply'), (menu_item, 'menu_item'), (ingredients, 'ingredients'),
                (menu, 'menu'), (wine_rating, 'wine'), (food, 'food'), (facility_stock, 'facility_stock'))

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
        amounts = []
        h = tree.xpath('//table[2]')[0]
        for i in h[1:]:
            amounts.append([float(i[1].text), i[3].text.replace("'", "")])
        price = randint(min, max)
        return {name: {'ingredients': amounts, 'price': price}}

other_supplies = [['Oven', 'kitchen supplies'],
                  ['Pan', 'kitchen supplies'],
                  ['Knife', 'kitchen supplies'],
                  ['Table', 'kitchen supplies'],
                  ['Fork', 'kitchen supplies'],
                  ['Tongs', 'kitchen supplies'],
                  ['Meat Hammer', 'kitchen supplies'],
                  ['Waffle Iron', 'kitchen supplies'],
                  ['Plate', 'serving items'],
                  ['Fork', 'serving items'],
                  ['Spoon', 'serving items'],
                  ['Knife', 'serving items'],
                  ['Steak Knife', 'serving items'],
                  ['Bowl', 'serving items'],
                  ['Napkins', 'serving items'],
                  ['Tray', 'serving items'],
                  ['Table Clothes', 'linens'],
                  ['Aprons', 'linens'],
                  ['Fry Pans', 'kitchen supplies'],
                  ['Ingredient Bins', 'kitchen supplies'],
                  ['Sheet Pans', 'kitchen supplies'],
                  ['Roast Pan', 'kitchen supplies'],
                  ['Stock Pot', 'kitchen supplies'],
                  ['Deep Boiler', 'kitchen supplies'],
                  ['Pasta Cooker', 'kitchen supplies'],
                  ['Sauce Pot', 'kitchen supplies'],
                  ['Sauce Pan', 'kitchen supplies'],
                  ['Pizza Pan', 'kitchen supplies'],
                  ['Pizza Dough Boxes', 'kitchen supplies'],
                  ['Sheet Pan', 'kitchen supplies'],
                  ['Tongs', 'kitchen supplies'],
                  ['Disher', 'kitchen supplies'],
                  ['Ladle', 'kitchen supplies'],
                  ['Egg Slicer', 'kitchen supplies'],
                  ['Tapered Grater', 'kitchen supplies'],
                  ['Grill Cover', 'kitchen supplies'],
                  ['Steak Weight', 'kitchen supplies'],
                  ['Pancake Dispenser Stand', 'kitchen supplies'],
                  ['Dredge', 'kitchen supplies'],
                  ['Sandwich Spreader', 'kitchen supplies'],
                  ['Fish Turner', 'kitchen supplies'],
                  ['Cutting Board for Meat', 'kitchen supplies'],
                  ['Cutting Board for Fish', 'kitchen supplies'],
                  ['Cutting Board for Poultry', 'kitchen supplies'],
                  ['Knife Rack', 'kitchen supplies'],
                  ['Professional Cimeter', 'kitchen supplies'],
                  ['Cleaver', 'kitchen supplies'],
                  ['Sharpening Steel', 'kitchen supplies'],
                  ['Refrigerator/Freezer Thermometer', 'kitchen supplies'],
                  ['Can Opener', 'kitchen supplies'],
                  ['Nitrile Gloves', 'linens'],
                  ['Oven Mitt', 'linens'],
                  ['Cloth Pot Holder', 'linens'],
                  ['Digital Scale', 'kitchen supplies'],
                  ['Manual Slicer', 'kitchen supplies'],
                  ['Table Skirting', 'linens'],
                  ['Vinyl Tablecloth', 'linens'],
                  ['Salt and Pepper Shaker', 'serving items'],
                  ['Single Jacket Menu', 'serving items'],
                  ['Menu Holder', 'serving items'],
                  ['Tabletop Sign Holder', 'serving items'],
                  ['Table Top Napkin Holders', 'serving items'],
                  ['Napkins', 'serving items'],
                  ['Straw Dispenser', 'serving items'],
                  ['Straw', 'serving items'],
                  ['Cone Holder', 'serving items'],
                  ['Countertop Organizer', 'serving items'],
                  ['Beverage Dispenser', 'serving items'],
                  ['Tea Urn', 'serving items'],
                  ['Coffee Maker', 'serving items'],
                  ['Espresso Maker', 'serving items'],
                  ['Panini Grill', 'kitchen supplies'],
                  ['Rice Cooker/Warmer', 'kitchen supplies'],
                  ['Filter Drain Pot', 'kitchen supplies'],
                  ['Bottle Cooler', 'kitchen supplies'],
                  ['Overhead Glass Rack', 'kitchen supplies'],
                  ['Ice bin', 'kitchen supplies'],
                  ['Champagne Bucket and Stand', 'serving items'],
                  ['Waiter Corkscrew', 'serving items'],
                  ['Glass Storage Rack', 'kitchen supplies'],
                  ['Sink', 'kitchen supplies'],
                  ['Drainboards', 'kitchen supplies'],
                  ['Refrigerator', 'kitchen supplies'],
                  ['Freezer', 'kitchen supplies'],
                  ['Chairs', 'serving items']]

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
    'wines': {'Cune Rioja Imperial Gran Reserva': {'ingredients': [[1.0, 'Cune Rioja Imperial Gran Reserva']], 'price': 63},
              'Chateau Canon-La Gaffeliere St.-Emilion': {'ingredients': [[1.0, 'Chateau Canon-La Gaffeliere St.-Emilion']], 'price': 21},
              'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve': {'ingredients': [[1.0, 'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve']], 'price': 20},
              'Hewitt Cabernet Sauvignon Rutherford': {'ingredients': [[1.0, 'Hewitt Cabernet Sauvignon Rutherford']], 'price': 29},
              'Kongsgaard Chardonnay Napa Valley': {'ingredients': [[1.0, 'Kongsgaard Chardonnay Napa Valley']], 'price': 27},
              'Giuseppe Mascarello & Figlio Barolo Monprivato': {'ingredients': [[1.0, 'Giuseppe Mascarello & Figlio Barolo Monprivato']], 'price': 21},
              'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee': {'ingredients': [[1.0, 'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee']], 'price': 21},
              'Chateau de Beaucastel Chateauneuf-du-Pape': {'ingredients': [[1.0, 'Chateau de Beaucastel Chateauneuf-du-Pape']], 'price': 21},
              'Lewis Cabernet Sauvignon Napa Valley Reserve': {'ingredients': [[1.0, 'Lewis Cabernet Sauvignon Napa Valley Reserve']], 'price': 21},
              'Quilceda Creek Cabernet Sauvignon Columbia Valley': {'ingredients': [[1.0, 'Quilceda Creek Cabernet Sauvignon Columbia Valley']], 'price': 21},
              'Reynvaan Syrah Walla Walla Valley Stonessence': {'ingredients': [[1.0, 'Reynvaan Syrah Walla Walla Valley Stonessence']], 'price': 27},
              'Turley Zinfandel Paso Robles Dusi Vineyard': {'ingredients': [[1.0, 'Turley Zinfandel Paso Robles Dusi Vineyard']], 'price': 24},
              'Croft Vintage Port': {'ingredients': [[1.0, 'Croft Vintage Port']], 'price': 29},
              'Bedrock The Bedrock Heritage Sonoma Valley': {'ingredients': [[1.0, 'Bedrock The Bedrock Heritage Sonoma Valley']], 'price': 23},
              'Olivier Ravoire Gigondas': {'ingredients': [[1.0, 'Olivier Ravoire Gigondas']], 'price': 23},
              'G.D. Vajra Barolo Albe': {'ingredients': [[1.0, 'G.D. Vajra Barolo Albe']], 'price': 24},
              'Alexana Pinot Noir Dundee Hills Revana Vineyard': {'ingredients': [[1.0, 'Alexana Pinot Noir Dundee Hills Revana Vineyard']], 'price': 24},
              'Poggerino Chianti Classico': {'ingredients': [[1.0, 'Poggerino Chianti Classico']], 'price': 22},
              'Hamilton Russell Chardonnay Hemel-en-Aarde Valley': {'ingredients': [[1.0, 'Hamilton Russell Chardonnay Hemel-en-Aarde Valley']], 'price': 23},
              'Chateau Dereszla Tokaji Aszu 5 Puttonyos': {'ingredients': [[1.0, 'Chateau Dereszla Tokaji Aszu 5 Puttonyos']], 'price': 24},
              'Le Macchiole Bolgheri': {'ingredients': [[1.0, 'Le Macchiole Bolgheri']], 'price': 23},
              'La Rioja Alta Rioja Vina Ardanza Reserva': {'ingredients': [[1.0, 'La Rioja Alta Rioja Vina Ardanza Reserva']], 'price': 23},
              'Seghesio Zinfandel Dry Creek Valley Cortina': {'ingredients': [[1.0, 'Seghesio Zinfandel Dry Creek Valley Cortina']], 'price': 23},
              'Livio Sassetti Brunello di Montalcino Pertimali': {'ingredients': [[1.0, 'Livio Sassetti Brunello di Montalcino Pertimali']], 'price': 25},
              'Epoch Estate Blend Paderewski Vineyard Paso Robles': {'ingredients': [[1.0, 'Epoch Estate Blend Paderewski Vineyard Paso Robles']], 'price': 24},
              'Alvaro Palacios Priorat Les Terrasses Velles Vinyes': {'ingredients': [[1.0, 'Alvaro Palacios Priorat Les Terrasses Velles Vinyes']], 'price': 24},
              'Spring Valley Uriah Walla Walla Valley': {'ingredients': [[1.0, 'Spring Valley Uriah Walla Walla Valley']], 'price': 25},
              'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana': {'ingredients': [[1.0, 'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana']], 'price': 19}}}
