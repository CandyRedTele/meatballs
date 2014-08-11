
select m_id, mitem_id, menu_item.name as 'item name', supplies.sku, supplies.name as 'supply name'   from menu natural join menu_item natural join ingredients, supplies where menu.m_id = 1 and supplies.sku = ingredients.sku;
