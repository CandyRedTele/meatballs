# -*- coding: utf-8 -*-
from urlparse import urlparse
from lxml import html
import requests
from random import randint, sample, uniform

url = "http://hangryingreedytest.herokuapp.com/?recipe_url="
main_urls = ['http://allrecipes.com/Recipe/Worlds-Best-Lasagna/Detail.aspx?evt19=1',
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
desert_urls = ['http://allrecipes.com/Recipe/Chicken-Pot-Pie-IX/Detail.aspx?evt19=1',
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
entree_urls = ['http://allrecipes.com/Recipe/Mexican-Bean-Salad/Detail.aspx?evt19=1',
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

insert_supplies = 'INSERT INTO supply (sku, name, type) VALUES ('
insert_menuitems = 'INSERT INTO menu_item (mitem_id, category, price, name) VALUES ('
insert_ingredients = 'INSERT INTO ingredients (sku, mitem_id, amount) VALUES ('
insert_menus = 'INSERT INTO menu (m_id, type, mitem_id) VALUES ('
insert_wines = 'INSERT INTO wine (rate, mitem_id) VALUES ('


def helper_l_s(l):
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

class Recipe():

    def __init__(self):
        pass
        self.entree = self.getRecipe(entree_urls, 8, 16)
        self.main = self.getRecipe(main_urls, min=15, max=34)
        self.deserts = self.getRecipe(desert_urls, min=6, max=14)
        self.kids = self.getRecipe(kids_urls, min=8, max=15)
        self.supply, self.menu_item, self.ingredients, self.menu, self.wine = self.create_list()

    def create_dic(self):
        d= {"deserts": self.deserts, "main": self.main, "entree": self.entree, "kids": self.kids}
        #d= {"deserts": self.deserts}
        d.update(wines)
        return d
        #return wines

    def get_it_all(self):
        return self.get_ingredients() + self.get_supply() + self.get_menu_item() + self.get_menu() + self.get_wine()

    def get_ingredients(self):
        s = ""
        for i in self.ingredients:
            s += insert_ingredients
            s += helper_l_s(i)
            s += '); '
        return s

    def get_supply(self):
        s = ""
        for i in self.supply:
            s += insert_supplies
            s += helper_l_s(i)
            s += '); '
        return s

    def get_menu_item(self):
        s = ""
        for i in self.menu_item:
            s += insert_menuitems
            s += helper_l_s(i)
            s += '); '
        return s

    def get_menu(self):
        s = ""
        for i in self.menu:
            s += insert_menus
            s += helper_l_s(i)
            s += '); '
        return s

    def get_wine(self):
        s = ""
        for i in self.wine:
            s += insert_wines
            s += helper_l_s(i)
            s += '); '
        return s

    def create_list(self):
        d = self.create_dic()
        x = []
        for i in d.itervalues():
            for j in i.itervalues():
                for k in j['ingredients']:
                    x.append(k)
        ll = len(x)
        skus = sample(range(10000,49999), ll)
        supply = []
        index =0
        for i in d.itervalues():
            for j in i.itervalues():
                for k in j['ingredients']:
                    k.append(skus[index])
                    index +=1
                    supply.append([k[2], k[1], 'food'])

        menu_item = []
        index = 1
        for category, i in d.iteritems():
            for name, j in i.iteritems():
                j.update({'id':index})
                menu_item.append([index, category, j['price'], name])
                index +=1

        ingredients = []
        for i in d.itervalues():
            for j in i.itervalues():
                for k in j['ingredients']:
                    ingredients.append([k[2], j['id'], k[0]])

        menus_kind = []
        for i in range(17):
            menus_kind.append(menu_item[i::17])

        common_menus = menus_kind[12:]
        specific_menus = menus_kind[:12]

        c = [item for sublist in common_menus for item in sublist]

        for i in specific_menus:
            for j in c:
                i.append(j)

        menu = []
        for i, j in enumerate(specific_menus, start=1):
            for k in j:
                menu.append([i, k[0], k[1]])

        wine_kind = [i[0] for i in menu_item if i[1]=='wines']
        wine_rating = []
        for i in wine_kind:
            wine_rating.append([uniform(6.5, 10), i])

        return supply, menu_item, ingredients, menu, wine_rating

    def generateUrlRecipe(self, urls):
        newlist=[]
        for i in urls:
            newlist.append(url+i)
        return newlist

    def getRecipe(self, urll, min, max):
        menu_category = {}
        urls = self.generateUrlRecipe(urll)
        for i in urls:
            response = requests.get(i).text
            tree = html.fromstring(response)
            men = self.getMenu(tree, min, max)
            menu_category.update(men)
        return menu_category

    def getMenu(self, tree, min, max):
        h = tree.xpath('//table[1]//tr[2]/td[2]')[0]
        l = urlparse(h.text)
        name = l.path.split('/')[2]
        amounts = []
        h = tree.xpath('//table[2]')[0]
        for i in h[1:]:
            amounts.append([float(i[1].text), i[3].text.replace("'","")])
        price = randint(min, max)
        return {name:{'ingredients':amounts,'price':price}}

wines =   {'wines': {'Cune Rioja Imperial Gran Reserva': {'ingredients': [[1.0, 'Cune Rioja Imperial Gran Reserva']], 'price': 63},
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
