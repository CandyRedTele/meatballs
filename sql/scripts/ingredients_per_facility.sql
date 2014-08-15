use meatballs;
select menu_item.mitem_id, menu_item.name, ingredients.sku, supplies.name 
    from menu_item, ingredients, supplies 
    where ingredients.sku = supplies.sku 
        and menu_item.mitem_id = ingredients.mitem_id 
        and menu_item.mitem_id in (
            select menu_item.mitem_id 
                from menu_item, menu, facility 
                where menu_item.mitem_id = menu.mitem_id 
                    and menu.m_id = facility.m_id 
                    and facility.f_id = 1);
