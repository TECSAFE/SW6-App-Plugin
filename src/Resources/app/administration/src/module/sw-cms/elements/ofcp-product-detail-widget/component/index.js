import template from './sw-cms-el-ofcp-product-detail-widget.html.twig';
import './sw-cms-el-ofcp-product-detail-widget.scss';

const { Mixin } = Shopware;

/**
 * @private
 * @package buyers-experience
 */
export default {
    template,

    mixins: [
        Mixin.getByName('cms-element'),
    ],

    computed: {
        assetFilter() {
            return Shopware.Filter.getByName('asset');
        },
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('ofcp-product-detail-widget');
            this.initElementData('ofcp-product-detail-widget');
        },
    },
};
