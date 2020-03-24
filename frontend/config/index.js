// see http://vuejs-templates.github.io/webpack for documentation.
var path = require('path')

module.exports = {
    build: {
        env: require('./prod.env'),
        index: path.resolve(__dirname, '../public/bundle/index.html'),
        assetsRoot: path.resolve(__dirname, '../public'),
        assetsSubDirectory: 'bundle',
        assetsPublicPath: '',
        productionSourceMap: true,
        productionGzip: false,
        productionGzipExtensions: ['js', 'css']
    },
    dev: {
        env: require('./dev.env'),
        port: 8000,
        assetsSubDirectory: 'static',
        assetsPublicPath: '',
        cssSourceMap: false,
        openBrowser: false,
        proxyTable: {}
    }
}
