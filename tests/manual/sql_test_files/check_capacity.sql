select count(*)
        from
            (select sum(quantity) as 'sumnum', sku
                from facilityStock
                group by sku) quant,
            (select food.capacity as 'capacity', sku
                from food) cap
                where cap.sku = quant.sku and quant.sumnum >= cap.capacity
        
