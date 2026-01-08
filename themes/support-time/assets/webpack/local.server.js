const siteLocalURL = process.env.site_local_url;

if (!siteLocalURL || siteLocalURL === "URL_SITE")
    return console.error(
        'В файле package.json в "scripts": { "serve" } необходимо указать локальный URL сайта в переменную site_local_url (например: site_local_url=govorov.local)',
    );

const bs = require("browser-sync").create();
bs.init({
    watch: true,
    proxy: `https://${siteLocalURL}`,
    snippetOptions: {
        ignorePaths: `${siteLocalURL}/wp-admin/!**`,
    },
    online: true,
    https: true,
    files: [
        {
            match: ["**/*.php"],
            fn: function (event, file) {
                if (event === "change") {
                    bs.reload("*.php");
                    bs.notify("PHP обновлён!");
                }
            },
        },
        {
            match: ["**/*.css"],
            fn: function (event, file) {
                if (event === "change") {
                    bs.reload("*.css");
                    bs.notify("CSS обновлён!");
                }
            },
        },
        {
            match: ["**/*.js"],
            fn: function (event, file) {
                if (event === "change") {
                    bs.reload("*.js");
                    bs.notify("JS обновлён!");
                }
            },
        },
    ],
    ui: false,
});
