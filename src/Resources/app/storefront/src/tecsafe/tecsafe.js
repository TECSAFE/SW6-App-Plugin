import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';
import CookieStorageHelper from 'src/helper/storage/cookie-storage.helper';
import Plugin from '@shopware-storefront-sdk/plugin-system/plugin.class';
import TecsafeSdk from '@tecsafe/app-js-sdk/src/index.ts';
const PluginManager = window.PluginManager;

const TOKEN_AVAILABLE = 'Tecsafe_TokenAvailable';

export default class Tecsafe extends Plugin {
    static options = {
        cookieName: 'tecsafe-foam-configurator-enabled',
        urlAttribute: 'data-url',
        appUrl: '',
        productWidgetId: 'tecsafe-product-widget-container',
    };

    async init() {
        this.appUrl = this.el.dataset.appUrl;
        document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, this._handleInit.bind(this));

        await this._handleInit();

        let productWidgetEl = document.getElementById(this.options.productWidgetId);

        if (productWidgetEl) {
            this.$emitter.subscribe(TOKEN_AVAILABLE, this.createProductDetailWidget.bind(this, productWidgetEl));

            this.createProductDetailWidget(productWidgetEl);
        }
    }

    reloadToken() {
        this.api.reloadToken();
    }

    logout() {
        //this.api.logout();
    }

    async initApi() {
        this.api = await TecsafeSdk.initializeTecsafeApi(async () => {
            const response = await fetch("/tecsafe/ofcp/token");
            const json = await response.json();

            return json.token;
        }, {
            appUrl: this.appUrl,
        });
    }

    async _handleInit() {
        if (CookieStorageHelper.getItem(this.options.cookieName)) {
            const token =  await this.initApi();
            this.$emitter.publish(TOKEN_AVAILABLE);

            return token;
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
            return this.api.productDetailWidget(el);
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
                console.debug(cookieConfigurationPlugin);
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

