import { COOKIE_CONFIGURATION_UPDATE } from 'src/plugin/cookie/cookie-configuration.plugin';

document.$emitter.subscribe(COOKIE_CONFIGURATION_UPDATE, eventCallback);

function eventCallback(updatedCookies) {
    if (typeof updatedCookies.detail['tecsafe-foam-configurator-enabled'] !== 'undefined') {
        // The cookie with the cookie attribute "cookie-key-1" either is set active or from active to inactive
        let cookieActive = updatedCookies.detail['tecsafe-foam-configurator-enabled'];
        document.$emitter.publish('tecsafe-foam-configurator-enabled-cookie-accepted');
    } else {
        // The cookie with the cookie attribute "cookie-key-1" was not updated
    }
}
