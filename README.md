# Crossing Fonds Platform (WIP)

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- A copy of the Crossing Fonds Omeka database (e.g. `omeka.sql`). If you are not sure what these are or where to get them, you should contact the [Digital Humanities Innovation Lab](mailto:dhil@sfu.ca) for access. This file should be placed in the root folder.
- A copy of the files (images, etc). This should be placed in the root folder as `files/`.

## Initialize the Application

First you must setup the database for the first time

```bash
# Start the db service
docker compose up -d db
# ... wait 30 seconds until the process is finished ... #
# Then copy the SQL file into the root
docker cp omeka.sql omeka_db:/omeka.sql
# Then import the data
docker exec -it omeka_db bash -c "mysql -u omeka -pomeka omeka < /omeka.sql"
```

Once the database is setup, you can now start the application:

```bash
docker compose up -d --build

```

The Crossing Fonds platform should then be available at `http://localhost:8080/`