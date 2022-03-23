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
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['vue-style-loader', 'css-loader'],
            },
            {
                test: /\.scss$/,
                use: ['vue-style-loader', 'css-loader', 'sass-loader'],
            },
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'url-loader',
                options: {
                    name: '[name].[ext]?[hash]',
                    limit: 8192,
                },
            },
        ],
    }, 
    resolve: {
        extensions: ['*', '.js', '.vue'],
        symlinks: false,
    },
}
