import template from './sw-cms-el-preview-ofcp-product-detail-widget.html.twig';
import './sw-cms-el-preview-ofcp-product-detail-widget.scss';

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
