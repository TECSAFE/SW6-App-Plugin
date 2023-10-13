import './component'
import './preview'

Shopware.Service('cmsService').registerCmsBlock({
  name: 'tecsafe-ofcp',
  category: 'commerce',
  label: 'Tecsafe OFCP',
  component: 'sw-cms-block-tecsafe-ofcp',
  previewComponent: 'sw-cms-preview-tecsafe-ofcp',
  defaultConfig: {},
  slots: {},
});
