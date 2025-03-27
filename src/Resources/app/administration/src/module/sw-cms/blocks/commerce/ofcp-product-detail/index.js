/**
 * @private
 * @package buyers-experience
 */
Shopware.Component.register('sw-cms-preview-ofcp-product-detail', () => import('./preview'));
/**
 * @private
 * @package buyers-experience
 */
Shopware.Component.register('sw-cms-block-ofcp-product-detail', () => import('./component'));

/**
 * @private
 * @package buyers-experience
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'ofcp-product-detail',
    label: 'sw-cms.blocks.commerce.ofcpProductDetail.label',
    category: 'commerce',
    component: 'sw-cms-block-ofcp-product-detail',
    previewComponent: 'sw-cms-preview-ofcp-product-detail',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'boxed',
    },
    slots: {
        main: 'ofcp-product-detail-widget',
    },
});
