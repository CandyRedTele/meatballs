-- variables to use: TITLE, and FACILITY
SET @title = 'shift supervisor';
SET @facility = 1;
SELECT staff.staff_id, staff.name, staff.title, localstaff.f_id
    from staff, localstaff 
    where staff.title = @title 
        and staff.staff_id = localstaff.staff_id
        and localstaff.f_id = @facility;
