"use strict";

/******************************
 *
 *******************************/

/* import Libs */
import LazyLoad from "vanilla-lazyload";
import PopUp from "./components/popUp";

document.addEventListener("DOMContentLoaded", () => {
    const lazyLoadInstance = new LazyLoad({
        // Your custom settings go here
    });

    /* Плавный scroll к маяку (Beacon) по клику на *[data-scroll-beacon] */

    const btnScrollBeacon = document.querySelectorAll("*[data-scroll-beacon]");
    if (btnScrollBeacon.length > 0) {
        btnScrollBeacon.forEach(el => {
            el.addEventListener("click", () => {
                let where = el.getAttribute("data-scroll-beacon");
                let top = 150;
                let scrollTarget = document.getElementById(where);
                if (scrollTarget) {
                    scrollTarget = scrollTarget.getBoundingClientRect();
                    const headerActionBanner = document.querySelector("header.header .actions-box");
                    window.scrollBy({
                        top: headerActionBanner
                            ? scrollTarget.top - headerActionBanner.offsetHeight
                            : scrollTarget.top - top,
                        behavior: "smooth",
                    });
                }
            });
        });
    }

    /* Ссылка на блок */

    const btnLinkJS = document.querySelectorAll(".link-js");
    if (btnLinkJS.length > 0) {
        btnLinkJS.forEach(function (clickBtn) {
            clickBtn.style.cursor = "pointer";
            clickBtn.onclick = function () {
                const link = clickBtn.getAttribute("data-link");
                if (link) {
                    if (link.indexOf("http") >= 0) {
                        window.open(link, "_blank");
                    } else {
                        window.open("https://" + document.location.host + link);
                    }
                }
            };
        });
    }

    /* PopUp */
    document.addEventListener("click", ({ target }) => {
        new PopUp(target.closest(".popClick"));
    });

    /* Настройка меню */

    const headerSite = document.querySelector("header.header#header");
    if (headerSite) {
        const headerMenuSite = document.querySelector("#header nav.menu");

        if (headerMenuSite) {
            const headerFixBlock = headerSite.querySelector(".container_header");
            const isMobile = window.matchMedia("(max-width: 991.98px)").matches;
            const wpAdminBar = document.getElementById("wpadminbar");

            window.onscroll = () => {
                const haveClassFixed = headerFixBlock.classList.contains("fixed");
                let step = 1;
                headerSite.style.minHeight = `${headerSite.clientHeight}px`;

                const top = window.scrollY;
                if (top > step) {
                    if (!haveClassFixed) {
                        headerFixBlock.classList.add("fixed");
                        if (wpAdminBar) {
                            headerFixBlock.style.top = `${wpAdminBar.clientHeight}px`;
                        }
                    }
                }
                if (top < step) {
                    if (haveClassFixed) {
                        headerFixBlock.classList.remove("fixed");
                    }
                }
            };
            // - Мобильное меню
            const mobileMenu = document.getElementById("mobileMenu");
            if (mobileMenu && isMobile) {
                mobileMenu.addEventListener("click", () => {
                    mobileMenu.classList.toggle("active");
                });

                const mobileMenuPaste = document.getElementById("menu-paste");
                if (mobileMenuPaste) {
                    const btnMobileMenu = document.querySelector(".mobile-menu-button");
                    btnMobileMenu.addEventListener("click", () => {
                        btnMobileMenu.classList.toggle("active");

                        if (mobileMenuPaste.children.length <= 0) {
                            let copyMenu = document.querySelector("ul.navbar-nav");
                            if (copyMenu) {
                                // Клонируем меню
                                const clonedMenu = copyMenu.cloneNode(true);

                                // Создаем элемент для главной страницы
                                const homeItem = document.createElement("li");
                                homeItem.setAttribute("itemscope", "itemscope");
                                homeItem.setAttribute("itemtype", "https://www.schema.org/SiteNavigationElement");
                                homeItem.className = "menu-item menu-item-type-custom menu-item-object-custom nav-item";

                                const homeLink = document.createElement("a");
                                homeLink.setAttribute("title", "Главная");
                                homeLink.setAttribute("href", "/");
                                homeLink.className = "nav-link";
                                homeLink.textContent = "Главная";

                                homeItem.appendChild(homeLink);

                                // Вставляем ссылку на главную в начало клонированного меню
                                clonedMenu.insertBefore(homeItem, clonedMenu.firstChild);

                                // Добавляем клонированное меню с добавленным элементом
                                mobileMenuPaste.appendChild(clonedMenu);
                            } else {
                                console.error("Меню не найдено! Замени ID в main.js");
                            }
                        }
                    });
                }
            }
        }
    }

    /* Меняем дату на всем сайте внутри тегов с классом st-today-date */
    const stTodayDate = document.querySelectorAll(".st-today-date");
    if (stTodayDate.length > 0) {
        stTodayDate.forEach(el => {
            const now = new Date();
            el.innerText = now.getFullYear();
        });
    }
});
