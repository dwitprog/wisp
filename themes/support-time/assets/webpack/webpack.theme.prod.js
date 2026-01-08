const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

const { merge } = require("webpack-merge");
const common = require("../webpack.common");

// Модули обработчики
const modules = {
    rules: [
        {
            test: /\.(mjs|jsx|js)$/,
            use: ["babel-loader"],
        },
        {
            test: /\.(sa|sc|c)ss$/,
            use: [
                {
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                        publicPath: "/wp-content/themes/support-time/assets/min/",
                    },
                },
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
                filename: "img/[hash][ext][query]",
            },
        },
    ],
};

// Плагины
const plugins = [
    new MiniCssExtractPlugin({
        filename: "css/[name].min.css",
    }),
];

// Модули для оптимизации
const optimization = {
    minimize: true,
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
    minimizer: [new TerserPlugin()],
};

module.exports = merge(common, {
    mode: "production",
    target: "browserslist",
    module: modules,
    plugins,
    optimization,
});
