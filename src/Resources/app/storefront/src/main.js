import Tecsafe from "./tecsafe/tecsafe";
import {TecsafeApi} from "@tecsafe/app-js-sdk";
const PluginManager = window.PluginManager;

PluginManager.register('Tecsafe', Tecsafe, '[data-tecsafe-init]');

const appUrl = 'https://tecsafe-api-gateway.ddev.site:3000/';

async function handle() {
    const response = await fetch('/tecsafe/ofcp/token');
    console.debug(response);
    const json = await response.json();

    return json;
};

/*const api = new TecsafeApi(handle);
api.getToken().then(token => {
    console.log(token);
})
console.debug(api);*/