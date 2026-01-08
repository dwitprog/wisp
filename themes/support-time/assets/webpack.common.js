const path = require("path");
const webpack = require("webpack");

// Папка где всё творим
const context = path.resolve(__dirname, "../assets");

// Устанавливаем входные точки
const entry = {
    admin: "/js/admin.js",
    main: "/js/main.js",
    pagesScripts: "/js/pages.js",
    pages: "/js/pages-styles.js",
    postsScripts: "/js/posts.js",
    posts: "/js/posts-styles.js",
    styles: "/js/styles.js",
};

// Настройка файлов на выходе
const output = {
    filename: "js/[name].min.js",
    path: path.resolve(__dirname, "../assets/min"),
    publicPath: "/wp-content/themes/support-time/assets/min/",
};

// Модули обработчики
const modules = {
    rules: [
        {
            test: /\.(woff(2)?|eot|ttf|otf)$/,
            type: "asset/inline",
        },
    ],
};

// Плагины
const plugins = [
    // Добавляем глобальные функции
    /*new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
    }),*/
    new webpack.ProvidePlugin({
        Popper: ["popper.js", "default"],
    }),
];

// Модули для оптимизации
const optimization = {};

module.exports = {
    context,
    entry,
    output,
    module: modules,
    plugins,
    optimization,
};
