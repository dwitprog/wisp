const path = require("path");
const isDev = process.env.mode === "development";

let postcssConfig = {
    plugins: [
        require("postcss-preset-env"),
        require("postcss-combine-media-query"),
        require("postcss-sort-media-queries")({
            sort: "desktop-first",
        }),
    ],
    minimize: false,
};

if (!isDev) {
    postcssConfig = {
        plugins: [
            require("postcss-merge-rules"),
            require("autoprefixer"),
            require("postcss-preset-env"),
            require("postcss-short")({
                prefix: "x",
            }),
            require("postcss-combine-media-query"),
            require("postcss-sort-media-queries")({
                sort: "desktop-first",
            }),
            require("cssnano")({
                preset: [
                    "default",
                    {
                        discardComments: {
                            removeAll: true,
                        },
                    },
                ],
            }),
            require("postcss-extract-media-query")({
                output: {
                    path: path.resolve(__dirname, "../assets/min"),
                    name: "css/[name]-[query].css",
                },
                extractAll: false,
                stats: false,
                queries: {
                    "screen and (max-width: 1399.98px)": "max-1400",
                    "screen and (max-width: 1199.98px)": "max-1200",
                    "screen and (max-width: 991.98px)": "max-992",
                    "screen and (max-width: 767.98px)": "max-768",
                    "screen and (max-width: 575.98px)": "max-576",
                },
            }),
        ],
        minimize: true,
    };
}

module.exports = postcssConfig;
