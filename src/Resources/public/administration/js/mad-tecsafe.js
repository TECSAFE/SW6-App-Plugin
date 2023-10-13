(()=>{var e=`{% block sw_cms_block_tecsafe_ofcp %}
    <div style="display: flex; justify-content: center; background-color: #ffcccc; padding: 10px; border: 1px solid #ff0000; margin-top: 1rem; margin-bottom: 1rem">
        <p>TECSAFE OFCP</p>
    </div>
{% endblock %}
`;Shopware.Component.register("sw-cms-block-tecsafe-ofcp",{template:e});var c=`{% block sw_cms_preview_tecsafe_ofcp %}
    <div style="display: flex; justify-content: center; background-color: #ffcccc; padding: 10px; border: 1px solid #ff0000">
        <p>TECSAFE OFCP</p>
    </div>
{% endblock %}
`;Shopware.Component.register("sw-cms-preview-tecsafe-ofcp",{template:c});Shopware.Service("cmsService").registerCmsBlock({name:"tecsafe-ofcp",category:"commerce",label:"Tecsafe OFCP",component:"sw-cms-block-tecsafe-ofcp",previewComponent:"sw-cms-preview-tecsafe-ofcp",defaultConfig:{},slots:{}});})();
