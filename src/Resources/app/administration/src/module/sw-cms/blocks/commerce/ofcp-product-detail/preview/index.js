import template from './sw-cms-preview-ofcp-product-detail.html.twig';
import './sw-cms-preview-ofcp-product-detail.scss';

/**
 * @private
 * @package buyers-experience
 */
export default {
    template,

    computed: {
        assetFilter() {
            return Shopware.Filter.getByName('asset');
        },
    },
};
