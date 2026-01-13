export default function pagesScripts() {
    const url = decodeURI(window.location.pathname);

    switch (url) {
        // Example: case '/extern/' : import(/* webpackChunkName: "script-page-9" */ './pages/extern/9'); break;

        case "/":
            import(/* webpackChunkName: "script-page-7" */ "./pages/7");
            break;
        case "/services/":
            import(/* webpackChunkName: "script-page-29" */ "./pages/29");
            break;
    }
}
