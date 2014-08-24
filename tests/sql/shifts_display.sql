SET @title = "shift supervisor";
SET @f_id = 1;
use meatballs;
SELECT name, title, f_id, date, time_start, time_end 
    FROM staff NATURAL JOIN shift NATURAL JOIN localstaff 
    WHERE title = @title AND f_id = @f_id;
