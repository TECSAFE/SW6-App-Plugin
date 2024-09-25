# SW6-App-Plugin
Provides a Plugin to integrate the TECSAFE App into a Shopware 6 Shop.

## ddev environment

In a ddev environment, the entire project is usually mounted in the web container.

However, this procedure is not suitable for the development of a Shopware plugin because a running Shopware instance 
is required and only the plugin from the source code needs to be mounted in the `custom/plugins` directory.

For the running Shopware instance, a copy of Shopware is imported from the **dockerware** project into the web container 
in the document root `/var/www/html` in `.ddev/web-build/Dockerfile.shopware`.

To prevent the entire project from being mounted in the web container, the value `no_project_mount` is set to `true` 
in `.ddev/config.yaml`.

The project directory is then mounted in the web container via docker-mount 
as `/var/www/html/custom/plugins/MadTecsafe` in `.ddev/docker-compose.mount.yaml`.

This procedure means that there is no shared `public/assets` folder and the plugin assets have to be rebuilt 
manually each time ddev is started.

### Spin up ddev-development environment

    ddev start

The project root is now mounted as Plugin `MadTecsafe` in /var/www/html/custom/plugins/MadTecsafe

The shop is available under https://tecsafe-sw6-plugin.ddev.site

### (optional) Copy Shopware sources for auto-completion

    docker cp ddev-tecsafe-sw6-plugin-web:/var/www/html/vendor/ ./shopware-source/


### Login to web-container

```bash
ddev ssh
```

### 8. Install and activate plugin

The `MadTecsafe`-Plugin should be installed already. Otherwise, install it manually: 

```bash
bin/console plugin:refresh && bin/console plugin:install --activate MadTecsafe
```

### 9. Plugin configuration via env vars
You can override plugin configuration values with environment variables:
```dotenv
TECSAFE_SALES_CHANNEL_SECRET_ID
TECSAFE_SALES_CHANNEL_SECRET_KEY
TECSAFE_SHOP_API_GATEWAY_URL
TECSAFE_APP_URL
```

## webpack-watcher

You can use the watcher scripts provided by shopware for hot module reloading during development.
The storefront and administration musst be accessed via different urls.

### Admin-watcher

```bash
ddev ssh
bin/build-administration.sh     # Copies static assets like images to public/bundles
bin/watch-administration.sh
```

Admin-Url: http://tecsafe-sw6-plugin.ddev.site:9997/

Beware: You have to use a private browser tab because of `http` and skip the `/admin` suffix.


### Storefront-watcher

```bash
ddev ssh
bin/build-storefront.sh         # Copies static assets like images to public/bundles
bin/watch-storefront.sh
```

Storefront-Url: http://tecsafe-sw6-plugin.ddev.site:9998/ 

Beware: You have to use a private browser tab because of `http`.
