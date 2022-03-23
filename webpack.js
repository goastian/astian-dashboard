const path = require('path') 

module.exports = {
    entry: {
        'edashboard': path.join(__dirname, 'src', 'edashboard.js'),
    },
    output: {
        path: path.resolve(__dirname, './js'),
        publicPath: '/js',
        filename: '[name].js?v=[hash]',
        chunkFilename: 'chunks/[name]-[hash].js',
    },
    resolve: {
        extensions: ['*', '.js', '.vue'],
        symlinks: false,
    },
}
