use meatballs;
select g_id, concat(firstname, ' ', lastname) as 'golden name', sum(price) as 'total spent'
    from golden natural join golden_has_bills natural join bill natural join bill_has_menu_item natural join menu_item
    group by g_id
    order by g_id;