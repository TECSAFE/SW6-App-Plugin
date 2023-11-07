//import Plugin from 'src/plugin-system/plugin.class';

import TecsafeSdk from '@tecsafe/app-js-sdk/src/index.ts';
import ProductDetailWidget from "@tecsafe/app-js-sdk/src/ProductDetailWidget.ts";

export default class Tecsafe extends Plugin {
    api

    async init() {
        this.api = await TecsafeSdk.initializeTecsafeApi(async () => {
            const response = await fetch("/tecsafe/ofcp/token");
            const json = await response.json();

            return json.token;
        });
    }

    reloadToken() {
        this.api.reloadToken();
    }

    logout() {
        this.api.logout();
    }

    /**
     *
     * @param el HtmlElement
     * @returns {ProductDetailWidget}
     */
    createProductDetailWidget(el) {
        return this.api.productDetailWidget(el);
    }
}

const PluginManager = window.PluginManager;
PluginManager.register('Tecsafe', Tecsafe, '[data-tecsafe-plugin]');
