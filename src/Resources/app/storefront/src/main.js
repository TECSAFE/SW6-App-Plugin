import Tecsafe from "./tecsafe/tecsafe";
const PluginManager = window.PluginManager;

PluginManager.register('Tecsafe', Tecsafe, '[data-tecsafe-init]');
