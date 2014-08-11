from urlparse import urlparse
from lxml import html
import requests
import json
from random import randint, sample, uniform

inserts = {'supply': 'INSERT INTO supplies (sku, name, type) VALUES (',
           'menu_item': 'INSERT INTO menu_item (mitem_id, category, price, name) VALUES (',
           'ingredient': 'INSERT INTO ingredients (sku, mitem_id, amount) VALUES (',
           'menu': 'INSERT INTO menu (m_id, mitem_id) VALUES (',
           'wine': 'INSERT INTO wine (rate, mitem_id) VALUES (',
           'food': 'INSERT INTO food (sku, capacity, days_till_expired, perishable) VALUES ('}


class Recipe():

    def __init__(self):
        #self.entree = self.getRecipe(entree_urls, 8, 16)
        #self.main = self.getRecipe(main_urls, min=15, max=34)
        #self.deserts = self.getRecipe(desert_urls, min=6, max=14)
        #self.kids = self.getRecipe(kids_urls, min=8, max=15)
        self.supply, self.menu_item, self.ingredient, self.menu, self.wine, self.other_supply, self.food = self.create_list()

    def get_inserts(self, table, insert_statement):
        s = "use meatballs; "
        for i in table:
            s += insert_statement
            s += self.helper_l_s(i)
            s += '); '
        return s

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
        #d = {"deserts": self.deserts, "main": self.main,
             #"entree": self.entree, "kids": self.kids}
        #d.update(wines)
        with open('supply_menu.json', 'rb') as fp:
            d = json.load(fp)
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

        return supply, menu_item, ingredients, menu, wine_rating, other_supplies, food

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
