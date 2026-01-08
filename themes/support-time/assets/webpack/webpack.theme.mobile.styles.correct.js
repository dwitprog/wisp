const path = require("path");

const ReplaceInFileWebpackPlugin = require("replace-in-file-webpack-plugin");

const { merge } = require("webpack-merge");
const common = require("../webpack.common");

// Удаляем все входные точки
common.entry = {};

// Настройка файлов на выходе
const output = {
    clean: false,
    path: path.resolve(__dirname, "../min"),
    publicPath: "/wp-content/themes/support-time/assets/min/",
};

// Плагины
const plugins = [
    new ReplaceInFileWebpackPlugin([
        {
            dir: path.resolve(__dirname, "../min/css"),
            test: /\.css$/,
            rules: [
                {
                    search: new RegExp("url\\(\\.\\.\\/img\\/", "ig"),
                    replace: function () {
                        return `url(../../img/`;
                    },
                },
            ],
        },
        {
            dir: path.resolve(__dirname, "../assets"),
            files: ["../../functions.php"],
            rules: [
                {
                    search: new RegExp("'_rgbld_(.*?)'", "ig"),
                    replace: function () {
                        const date = new Date();
                        let dayOfMonth = date.getDate();
                        let month = date.getMonth() + 1;
                        let year = date.getFullYear();
                        return `'_rgbld_${dayOfMonth + "_" + month + "_" + year}'`;
                    },
                },
            ],
        },
    ]),
];

module.exports = merge(common, {
    context: path.resolve(__dirname, "../assets"),
    mode: "production",
    output,
    plugins,
});
