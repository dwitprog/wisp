const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const { merge } = require("webpack-merge");
const common = require("../webpack.common");

// Настройка файлов на выходе
common.output.clean = true;

// Модули обработчики
const modules = {
    rules: [
        {
            test: /\.(mjs|jsx|js)$/,
            exclude: /(node_modules|bower_components)/,
            use: ["babel-loader"],
        },
        {
            test: /\.(sa|sc|c)ss$/,
            use: [
                MiniCssExtractPlugin.loader,
                "css-loader",
                "postcss-loader",
                "resolve-url-loader",
                {
                    loader: "sass-loader",
                    options: {
                        sourceMap: true,
                    },
                },
            ],
        },
        {
            test: /\.(?:ico|svg|gif|png|jpg|jpeg)$/i,
            type: "asset/resource",
            generator: {
                filename: "img/[contenthash][ext]",
            },
        },
    ],
};

// Плагины
const plugins = [
    new MiniCssExtractPlugin({
        filename: "css/[name].min.css",
        ignoreOrder: true,
    }),
];

// Модули для оптимизации
const optimization = {
    minimize: false,
    splitChunks: {
        cacheGroups: {
            vendors: {
                test: /[\\/]node_modules[\\/](swiper|animate.css|bootstrap-icons|bootstrap|swal|LazyLoad)[\\/]/,
                name: "vendors",
                chunks: "all",
                enforce: true,
            },
        },
    },
};

module.exports = merge(common, {
    watch: true,
    mode: "development",
    devtool: "eval",
    module: modules,
    plugins,
    optimization,
});
