const { join, resolve } = require('path');
//const babelrc = require('./.babelrc');

module.exports = (params) => {
    return {
        module: {
            rules: [
                {
                    test: /\.m?(t|j)s$/,
                    use: [
                        {
                            loader: 'swc-loader',
                        },
                    ],
                },
            ]
        },
        resolve: {
            alias: {
                '@tecsafe/app-js-sdk': resolve(
                    join(__dirname, '..', 'node_modules', '@tecsafe/app-js-sdk')
                ),
                'tiny-typed-emitter': resolve(
                    join(__dirname, '..', 'node_modules', 'tiny-typed-emitter'),
                ),
                'jwt-decode': resolve(
                    join(__dirname, '..', 'node_modules', 'jwt-decode'),
                ),
                '@shopware-storefront-sdk': resolve(
                    join(__dirname, '..', 'node_modules', 'shopware-storefront-sdk'),
                ),
                'babel-loader': resolve(
                    join(__dirname, '..', 'node_modules', 'babel-loader'),
                ),
            },
            extensions: ['.ts'],
            modules: [
                `${params.basePath}/Resources/app/storefront/node_modules`,
            ],
        },
    };
}