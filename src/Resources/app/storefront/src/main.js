import { COOKIE_CONFIGURATION_UPDATE, COOKIE_CONFIGURATION_CLOSE_OFF_CANVAS } from 'src/plugin/cookie/cookie-configuration.plugin';
import CookieStorageHelper from 'src/helper/storage/cookie-storage.helper';
import Plugin from '@shopware-storefront-sdk/plugin-system/plugin.class';

import TecsafeSdk from '@tecsafe/app-js-sdk/src/index.ts';
import ProductDetailWidget from "@tecsafe/app-js-sdk/src/ProductDetailWidget.ts";


export default class Tecsafe extends Plugin {
    static options = {
        cookieName: 'tecsafe-foam-configurator-enabled',
        btnClasses: [],
        videoUrl: null,
        iframeClasses: [],
        overlayText: null,
        backdropClasses: ['element-loader-backdrop', 'element-loader-backdrop-open'],
        confirmButtonText: null,
        modalTriggerSelector: '[data-bs-toggle="modal"][data-url]',
        urlAttribute: 'data-url',
    };

    init() {
        console.log('foobaz');
        document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, this._handleInit.bind(this));
        //document.$emitter.subscribe(CMS_GDPR_VIDEO_ELEMENT_REPLACE_ELEMENT_WITH_VIDEO, this._replaceElementWithVideo.bind(this));
        this._handleInit();
        /*this.backdropElement = this.createElementBackdrop();
        this.el.appendChild(this.backdropElement);*/
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
        });
    }

    _handleInit() {
        if (CookieStorageHelper.getItem(this.options.cookieName)) {
            return this.initApi();
        }
    }

    /**
     *
     * @param el HtmlElement
     * @returns {ProductDetailWidget}
     */
    createProductDetailWidget(el) {
        return this.api.productDetailWidget(el);
    }

    createElementBackdrop() {
        const backdropElement = document.createElement('div');
        backdropElement.classList.add('foobar');

        const childWrapper = document.createElement('div');

        backdropElement.appendChild(childWrapper);

        return backdropElement;
    }

    _replaceElementWithVideo() {
        console.log('heyho');
        const videoElement = document.createElement('iframe');
        videoElement.setAttribute('src', this.options.videoUrl);

        this.options.iframeClasses.forEach((cls) => {
            videoElement.classList.add(cls);
        });

        const parentNode = this.el.parentNode;
        parentNode.appendChild(videoElement);
        parentNode.removeChild(this.el);

        return true;
    }
}

const PluginManager = window.PluginManager;
PluginManager.register('Tecsafe', Tecsafe, '[data-tecsafe-plugin]');
