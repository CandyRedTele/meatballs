from random import randint
from urlparse import urlparse
from lxml import html
import json
import requests
from math import ceil

base_url = "http://hangryingreedytest.herokuapp.com/?recipe_url="

class dataRecipe():
    def __init__(self):
        self.vendors = vendors
        self.other_supplies = other_supplies

def create_dic():
    d = dict()
    entree = get_recipe(entree_urls, min=8, max=16)
    main = get_recipe(main_urls, min=15, max=34)
    deserts = get_recipe(desert_urls, min=6, max=14)
    kids = get_recipe(kids_urls, min=8, max=15)
    d = {"deserts": deserts, "main": main,
         "entree": entree, "kids": kids}
    d.update(wines)
    with open('supply_menu.json', 'w') as fp:
        json.dump(d, fp)
    return d

def generateUrlRecipe(urls):
    """ Create the list of recipe urls """
    newlist = []
    for i in urls:
        newlist.append(base_url + i)
    return newlist

def get_recipe(urll, min, max):
    """ Helper to execute the parsing """
    menu_category = {}
    urls = generateUrlRecipe(urll)
    for i in urls:
        response = requests.get(i).text
        tree = html.fromstring(response)
        menu = get_menu(tree, min, max)
        menu_category.update(menu)
    return menu_category

def get_menu(tree, min_price, max_price):
    """ Parse the recipes """
    # Name of the recipe
    title_in_url = tree.xpath('//table[1]//tr[2]/td[2]')[0]
    title = urlparse(title_in_url .text)
    name = title.path.split('/')[2]
    # Format name
    name = name.replace('-', ' ').title()
    # Image of the recipe
    image = tree.xpath('//table[1]//tr[5]/td[2]')[0].text
    # Target table
    table = tree.xpath('//table[2]')[0]
    amounts = []
    ingre_names = []

    for row in table[1:]:
        ingre_n = row[3].text.replace("'", "")
        if not ingre_names.count(ingre_n):
            ingre_names.append(ingre_n)
            # Format the quantity
            qty = int(ceil(float(row[1].text)))
            # Make sure an ingredient have at least one an amount of 1.
            if qty == 0:
                qty = 1
            amounts.append([qty, ingre_n])
    # Attribute a price to the plate
    price = randint(min_price, max_price)
    return {name: {'ingredients': amounts, 'price': price, 'image': image}}

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
        'wines': {'Cune Rioja Imperial Gran Reserva': {'ingredients': [[1, 'Cune Rioja Imperial Gran Reserva']], 'price': 63, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau Canon-La Gaffeliere St.-Emilion': {'ingredients': [[1, 'Chateau Canon-La Gaffeliere St.-Emilion']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve': {'ingredients': [[1, 'Domaine Serene Pinot Noir Willamette Valley Evenstad Reserve']], 'price': 20, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Hewitt Cabernet Sauvignon Rutherford': {'ingredients': [[1, 'Hewitt Cabernet Sauvignon Rutherford']], 'price': 29, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Kongsgaard Chardonnay Napa Valley': {'ingredients': [[1, 'Kongsgaard Chardonnay Napa Valley']], 'price': 27, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Giuseppe Mascarello & Figlio Barolo Monprivato': {'ingredients': [[1, 'Giuseppe Mascarello & Figlio Barolo Monprivato']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee': {'ingredients': [[1, 'Domaine du Pegau Chateauneuf-du-Pape Cuvee Reservee']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau de Beaucastel Chateauneuf-du-Pape': {'ingredients': [[1, 'Chateau de Beaucastel Chateauneuf-du-Pape']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Lewis Cabernet Sauvignon Napa Valley Reserve': {'ingredients': [[1, 'Lewis Cabernet Sauvignon Napa Valley Reserve']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Quilceda Creek Cabernet Sauvignon Columbia Valley': {'ingredients': [[1, 'Quilceda Creek Cabernet Sauvignon Columbia Valley']], 'price': 21, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Reynvaan Syrah Walla Walla Valley Stonessence': {'ingredients': [[1, 'Reynvaan Syrah Walla Walla Valley Stonessence']], 'price': 27, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Turley Zinfandel Paso Robles Dusi Vineyard': {'ingredients': [[1, 'Turley Zinfandel Paso Robles Dusi Vineyard']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Croft Vintage Port': {'ingredients': [[1, 'Croft Vintage Port']], 'price': 29, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Bedrock The Bedrock Heritage Sonoma Valley': {'ingredients': [[1, 'Bedrock The Bedrock Heritage Sonoma Valley']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Olivier Ravoire Gigondas': {'ingredients': [[1, 'Olivier Ravoire Gigondas']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'G.D. Vajra Barolo Albe': {'ingredients': [[1, 'G.D. Vajra Barolo Albe']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Alexana Pinot Noir Dundee Hills Revana Vineyard': {'ingredients': [[1, 'Alexana Pinot Noir Dundee Hills Revana Vineyard']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Poggerino Chianti Classico': {'ingredients': [[1, 'Poggerino Chianti Classico']], 'price': 22, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Hamilton Russell Chardonnay Hemel-en-Aarde Valley': {'ingredients': [[1, 'Hamilton Russell Chardonnay Hemel-en-Aarde Valley']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Chateau Dereszla Tokaji Aszu 5 Puttonyos': {'ingredients': [[1, 'Chateau Dereszla Tokaji Aszu 5 Puttonyos']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Le Macchiole Bolgheri': {'ingredients': [[1, 'Le Macchiole Bolgheri']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'La Rioja Alta Rioja Vina Ardanza Reserva': {'ingredients': [[1, 'La Rioja Alta Rioja Vina Ardanza Reserva']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Seghesio Zinfandel Dry Creek Valley Cortina': {'ingredients': [[1, 'Seghesio Zinfandel Dry Creek Valley Cortina']], 'price': 23, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Livio Sassetti Brunello di Montalcino Pertimali': {'ingredients': [[1, 'Livio Sassetti Brunello di Montalcino Pertimali']], 'price': 25, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Epoch Estate Blend Paderewski Vineyard Paso Robles': {'ingredients': [[1, 'Epoch Estate Blend Paderewski Vineyard Paso Robles']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Alvaro Palacios Priorat Les Terrasses Velles Vinyes': {'ingredients': [[1, 'Alvaro Palacios Priorat Les Terrasses Velles Vinyes']], 'price': 24, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Spring Valley Uriah Walla Walla Valley': {'ingredients': [[1, 'Spring Valley Uriah Walla Walla Valley']], 'price': 25, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'},
              'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana': {'ingredients': [[1, 'Bodegas Hidalgo Gitana Manzanilla Jerez La Gitana']], 'price': 19, 'image': 'http://www.greenerpackage.com/sites/default/files/Boisset.jpg'}}}

other_supplies = [['Oven', 'kitchen supplies', 1000], ['Pan', 'kitchen supplies', 50],
                  ['Knife', 'kitchen supplies', 5], ['Table', 'kitchen supplies', 50],
                  ['Fork', 'kitchen supplies', 5], ['Tongs', 'kitchen supplies', 5],
                  ['Meat Hammer', 'kitchen supplies', 60], ['Waffle Iron', 'kitchen supplies', 50],
                  ['Plate', 'service items', 5], ['Fork', 'service items', 5],
                  ['Spoon', 'service items', 5], ['Knife', 'service items', 5],
                  ['Steak Knife', 'service items', 6], ['Bowl', 'service items', 5],
                  ['Napkins', 'service items', 1], ['Tray', 'service items', 4],
                  ['Table Clothes', 'linens', 15], ['Aprons', 'linens', 6],
                  ['Fry Pans', 'kitchen supplies', 21], ['Ingredient Bins', 'kitchen supplies', 10],
                  ['Sheet Pans', 'kitchen supplies', 50], ['Roast Pan', 'kitchen supplies', 20],
                  ['Stock Pot', 'kitchen supplies', 80], ['Deep Boiler', 'kitchen supplies', 60],
                  ['Pasta Cooker', 'kitchen supplies', 50], ['Sauce Pot', 'kitchen supplies', 30],
                  ['Sauce Pan', 'kitchen supplies', 20], ['Pizza Pan', 'kitchen supplies', 20],
                  ['Pizza Dough Boxes', 'kitchen supplies', 10], ['Sheet Pan', 'kitchen supplies', 14],
                  ['Tongs', 'kitchen supplies', 12], ['Disher', 'kitchen supplies', 10],
                  ['Ladle', 'kitchen supplies', 14], ['Egg Slicer', 'kitchen supplies', 12],
                  ['Tapered Grater', 'kitchen supplies', 12], ['Grill Cover', 'kitchen supplies', 21],
                  ['Steak Weight', 'kitchen supplies', 30], ['Pancake Dispenser Stand', 'kitchen supplies', 30],
                  ['Dredge', 'kitchen supplies', 21], ['Sandwich Spreader', 'kitchen supplies', 24],
                  ['Fish Turner', 'kitchen supplies', 21], ['Cutting Board for Meat', 'kitchen supplies', 18],
                  ['Cutting Board for Fish', 'kitchen supplies', 18], ['Cutting Board for Poultry', 'kitchen supplies', 18],
                  ['Knife Rack', 'kitchen supplies', 38], ['Professional Cimeter', 'kitchen supplies', 50],
                  ['Cleaver', 'kitchen supplies', 21], ['Sharpening Steel', 'kitchen supplies', 21],
                  ['Refrigerator/Freezer Thermometer', 'kitchen supplies', 43], ['Can Opener', 'kitchen supplies', 15],
                  ['Nitrile Gloves', 'linens', 14], ['Oven Mitt', 'linens', 16],
                  ['Cloth Pot Holder', 'linens', 18], ['Digital Scale', 'kitchen supplies', 45],
                  ['Manual Slicer', 'kitchen supplies', 90], ['Table Skirting', 'linens', 60],
                  ['Vinyl Tablecloth', 'linens', 20], ['Salt and Pepper Shaker', 'service items', 10],
                  ['Single Jacket Menu', 'service items', 17], ['Menu Holder', 'service items', 10],
                  ['Tabletop Sign Holder', 'service items', 10], ['Table Top Napkin Holders', 'service items', 8],
                  ['Napkins', 'service items', 1], ['Straw Dispenser', 'service items', 10],
                  ['Straw', 'service items', 1], ['Cone Holder', 'service items', 12],
                  ['Countertop Organizer', 'service items', 45], ['Beverage Dispenser', 'service items', 120],
                  ['Tea Urn', 'service items', 80], ['Coffee Maker', 'service items', 140],
                  ['Espresso Maker', 'service items', 180], ['Panini Grill', 'kitchen supplies', 70],
                  ['Rice Cooker/Warmer', 'kitchen supplies', 90], ['Filter Drain Pot', 'kitchen supplies', 40],
                  ['Bottle Cooler', 'kitchen supplies', 30], ['Overhead Glass Rack', 'kitchen supplies', 40],
                  ['Ice bin', 'kitchen supplies', 90], ['Champagne Bucket and Stand', 'service items', 20],
                  ['Waiter Corkscrew', 'service items', 10], ['Glass Storage Rack', 'kitchen supplies', 12],
                  ['Sink', 'kitchen supplies', 300], ['Drainboards', 'kitchen supplies', 200],
                  ['Refrigerator', 'kitchen supplies', 1200], ['Freezer', 'kitchen supplies', 1300],
                  ['Chairs', 'service items', 40]]

vendors = [['Servu-online', '3201 Apollo Drive Champaign, IL', 'kitchen supplies'], ['PA Supermarche', '1420 Rue du Fort Montreal, QC', 'food'],
           ['Provigo', '3421 Avenue du Parc Montreal, QC', 'food'], ['Segals Market', '4001 Boulevard Saint-Laurent Montreal, QC', 'food'],
           ['Super C', '147 Avenue Atwater Montreal, QC', 'food'], ['Lucky', '4527 8 Ave SE, Calgary, AB', 'food'],
           ['Island Market', '1502 W 2nd Ave #120, Vancouver, BC', 'food'], ['Stong Markets', '4560 Dunbar St, Vancouver, BC', 'food'],
           ['Mikasa', '4450 Rochdale Blvd Regina, SK', 'service items'], ['George Courey', '326 Victoria Ave Westmount, QC', 'linens']]

