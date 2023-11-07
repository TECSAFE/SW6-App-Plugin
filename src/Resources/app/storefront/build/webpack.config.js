const { join, resolve } = require('path');
const babelrc = require('./.babelrc');

module.exports = () => {
    return {
        module: {
            rules: [
                {
                    test: /\.m?(t|j)s$/,
                    use: [
                        {
                            loader: 'babel-loader',
                            options: {
                                ...babelrc,
                                cacheDirectory: true,
                            },
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
                )

            },
            extensions: ['.ts'],
        },
    };
}
