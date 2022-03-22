const webpackConfig = require("@nextcloud/webpack-vue-config");
const path = require('path');

webpackConfig.output.path = path.resolve('./dist/js');
module.exports = webpackConfig;
