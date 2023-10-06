# SW6-App-Plugin
Provides a Plugin to integrate the TECSAFE App into a Shopware 6 Shop.

## Set up development environment

### 1. Comment plugin volume in `docker-compose.yaml`

```diff
    shopware:
    image: dockware/dev:6.5.0.0
    container_name: tecsafe-sw6-plugin-shopware
    ports:
      - "80:80"
      - "3306:3306"
      - "22:22"
      - "8888:8888"
      - "9999:9999"
      - "9998:9998"
    networks:
      - web
    environment:
      - XDEBUG_ENABLED=1
-   volumes:
-     - ".:/var/www/html/custom/plugins/MadTecsafe"
+   #volumes:
+   #  - ".:/var/www/html/custom/plugins/MadTecsafe"
```

### 2. Start docker containers

```bash 
docker compose up -d
``` 

### 3. Copy shopware source from container

```bash 
docker cp tecsafe-sw6-plugin-shopware:/var/www/html/. ./shopware-source
```

### 4. Stop docker containers

```bash 
docker compose stop
```

### 5. Uncomment plugin volume in `docker-compose.yaml`

```diff
    shopware:
    image: dockware/dev:6.5.0.0
    container_name: tecsafe-sw6-plugin-shopware
    ports:
      - "80:80"
      - "3306:3306"
      - "22:22"
      - "8888:8888"
      - "9999:9999"
      - "9998:9998"
    networks:
      - web
    environment:
      - XDEBUG_ENABLED=1
-   #volumes:
-   #  - ".:/var/www/html/custom/plugins/MadTecsafe"
+   volumes:
+     - ".:/var/www/html/custom/plugins/MadTecsafe"

```

### 6. Start containers

```bash 
docker compose up -d
```

The project root is now mounted as Plugin `MadTecsafe` in /var/www/html/custom/plugins/MadTecsafe

### Login to shopware container

```bash
docker compose exec shopware bash
```

### 8. Install and activate plugin

```bash
bin/console plugin:install --activate MadTecsafe
```
