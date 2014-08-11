# Step to generate the data.

- Open Ipython
    - %run recipe_getter.py
    - r = Recipe()
    - r.get_it_all()
    - %save supply _
- In Bash:
    - tail -n +2 supply.py > supply.sql
    - rm supply.py
