import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';
import CookieStorageHelper from 'src/helper/storage/cookie-storage.helper';
import Plugin from '@shopware-storefront-sdk/plugin-system/plugin.class';
import { TecsafeApi } from '@tecsafe/app-js-sdk';
const PluginManager = window.PluginManager;

const TOKEN_AVAILABLE = 'Tecsafe_TokenAvailable';

export default class Tecsafe extends Plugin {
    static options = {
        cookieName: 'tecsafe-foam-configurator-enabled',
        urlAttribute: 'data-url',
        appUrl: '',
        productWidgetId: 'tecsafe-product-widget-container',
        allowedOrigins: [],
    };

    async init() {
        document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, this._handleInit.bind(this));

        await this._handleInit();
        let productWidgetEl = document.getElementById(this.options.productWidgetId);

        if (productWidgetEl) {
            this.$emitter.subscribe(TOKEN_AVAILABLE, this.createProductDetailWidget.bind(this, productWidgetEl));

            this.createProductDetailWidget(productWidgetEl);
        }
    }

    refreshToken() {
        this.api.refreshToken();
    }

    logout() {
        this.api.destroyAll();
    }

    async initApi() {
        this.api = new TecsafeApi(async () => {
            const response = await fetch(window.router['frontend.tecsafe.ofcp.token']);
            const json = await response.json();

            return json.token;
        }, {
            appUrl: this.options.appUrl,
            widgetBaseURL: this.options.appUrl,
            /**
             * A list of allowed origins for the SDK to communicate with
             */
            allowedOrigins: this.options.allowedOrigins,
            /**
             * Iframe styles.transition property
             */
            iframeTransition: 'none',
            /**
             * Styles configuration for the apps. TBD.
             */
            styles: '',
        });
    }

    async _handleInit() {
        console.debug(this);
        if (CookieStorageHelper.getItem(this.options.cookieName)) {
            await this.initApi();
            this.$emitter.publish(TOKEN_AVAILABLE);

            return this.api.getToken();
        } else {
            //console.debug(this);
        }
    }

    /**
     *
     * @param el HtmlElement
     * @returns {ProductDetailWidget}
     */
    createProductDetailWidget(el) {
        if (this.api) {
            return this.api.createProductDetailWidget(el);
        } else {
            return this.createProductDetailWidgetPlaceholder(el);
        }
    }

    createProductDetailWidgetPlaceholder(el) {
        el.innerHTML = document.getElementById('product-widget-placeholder').innerHTML;

        el.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault();
            const cookieConfigurationPlugins = PluginManager.getPluginInstances('CookieConfiguration');

            if (cookieConfigurationPlugins.length > 0) {
                const cookieConfigurationPlugin = cookieConfigurationPlugins[0];

                if (cookieConfigurationPlugin instanceof Object) {
                    if (typeof cookieConfigurationPlugin.openOffCanvas === 'function') {
                        cookieConfigurationPlugin.openOffCanvas();
                    }
                }
            }
        })

        return el;
    }
}

