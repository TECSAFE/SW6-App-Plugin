console.log('tecsafe-ofcp.js loaded');

function getHttpClient() {
    return window.PluginManager.getPluginInstances(Object.keys(window.PluginManager.getPluginList()).find(x => {
        const plugin = window.PluginManager.getPluginInstances(x)[0]
        return !!(plugin && plugin._client)
    }))[0]._client
}

// TODO: Make this later more secure

window.addEventListener('message', (event) => {
    switch (event.data.type) {
        case 'tecsafe:ofcp:get:token':
            getHttpClient().get('/tecsafe/ofcp/token', (response) => {
                response = JSON.parse(response);
                event.source.postMessage({
                    type: 'tecsafe:ofcp:set:token',
                    ...(!!response?.token ? {token: response.token} : {error: true})
                }, '*');
                if (response?.error === 'not logged in') window.location.href = '/account/login';
            });
            break;
        case 'tecsafe:ofcp:open:editor':
            document.getElementById('tecsafe-ofcp-widget').classList.add('tecsafe-ofcp-fullscreen');
            break;
        case 'tecsafe:ofcp:open:widget':
            document.getElementById('tecsafe-ofcp-widget').classList.remove('tecsafe-ofcp-fullscreen');
            break;
        case 'tecsafe:ofcp:cart:updated':
            const widgets = PluginManager.getPluginInstances('CartWidget');
            for (let i = 0; i < widgets.length; i++) widgets[i].fetch();
            break;
        case 'tecsafe:ofcp:open:cart':
            const el = document.getElementById('tecsafe-ofcp-cart');
            el.classList.remove('tecsafe-ofcp-hidden');
            el.src = el.src + '';
            break;
        case 'tecsafe:ofcp:close:cart':
            document.getElementById('tecsafe-ofcp-cart').classList.add('tecsafe-ofcp-hidden');
            break;
    }
}, false);
