/**
 * @private
 * @package buyers-experience
 */
Shopware.Component.register('sw-cms-el-preview-ofcp-product-detail-widget', () => import('./preview'));
/**
 * @private
 * @package buyers-experience
 */
Shopware.Component.register('sw-cms-el-config-ofcp-product-detail-widget', () => import('./config'));
/**
 * @private
 * @package buyers-experience
 */
Shopware.Component.register('sw-cms-el-ofcp-product-detail-widget', () => import('./component'));

/**
 * @private
 * @package buyers-experience
 */
Shopware.Service('cmsService').registerCmsElement({
    name: 'ofcp-product-detail-widget',
    label: 'sw-cms.elements.ofcpProductDetailWidget.label',
    component: 'sw-cms-el-ofcp-product-detail-widget',
    configComponent: 'sw-cms-el-config-ofcp-product-detail-widget',
    previewComponent: 'sw-cms-el-preview-ofcp-product-detail-widget',
    defaultConfig: {
        needsConfirmation: {
            source: 'static',
            value: false,
        },
        previewMedia: {
            source: 'static',
            value: null,
            entity: {
                name: 'media',
            },
        },
    },
});
