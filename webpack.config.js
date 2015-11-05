'use strict';

var webpack = require('webpack');
var path = require('path');

module.exports = {
    context: path.join(__dirname, 'public'),
    entry: './js/app',
    output: {
        path: path.join(__dirname, 'public', 'js'),
        filename: 'bundle.js'
    },
    plugins: [
        new webpack.optimize.UglifyJsPlugin({
            comments: /FOO/
        })
    ]
};
