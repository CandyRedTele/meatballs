use meatballs;
select b_id, sum(price) as total 
    from bill natural join bill_has_menu_item natural join menu_item 
    group by b_id;
