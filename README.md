# Crossing Fonds Omeka (WIP)

## Install / setup

Step 0:

* Download Docker Desktop
* Pull this repository
* Get a copy of the data

Step 1:

Setup the database

```
docker compose up -d db

```

Step 2:

Add data from database

```
docker exec -it omeka_db bash -c "mysql -u omeka -pomeka omeka < /omeka_backup.sql"
```

Step 3: 

Start the application:

```
docker compose up -d --build

# Application should be available at localhost

```

