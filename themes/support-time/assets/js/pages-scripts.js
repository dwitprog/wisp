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
        case "/services/full-service/":
            import(/* webpackChunkName: "script-page-32" */ "./pages/32");
            break;
        case "/services/performance-marketing/":
            import(/* webpackChunkName: "script-page-34" */ "./pages/34");
            break;
        case "/services/audit-service/":
            import(/* webpackChunkName: "script-page-36" */ "./pages/36");
            break;
        case "/services/strategy-service/":
            import(/* webpackChunkName: "script-page-38" */ "./pages/38");
            break;
        case "/services/consulting-service/":
            import(/* webpackChunkName: "script-page-40" */ "./pages/40");
            break;
        case "/platforms/":
            import(/* webpackChunkName: "script-page-42" */ "./pages/42");
            break;
        case "/qa/":
            import(/* webpackChunkName: "script-page-44" */ "./pages/44");
            break;
        case "/how-we-work/":
            import(/* webpackChunkName: "script-page-46" */ "./pages/46");
            break;
    }
}
