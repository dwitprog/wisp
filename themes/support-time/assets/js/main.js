"use strict";

/******************************
 *
 *******************************/

/* import Libs */
import LazyLoad from "vanilla-lazyload";
import PopUp from "./components/popUp";
import { changeFontSize } from "./components/changeFontSize";

document.addEventListener("DOMContentLoaded", () => {
    changeFontSize();

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
        const headerMenuSite = headerSite.querySelector("#header nav.header-menu");
        const mobileMenuBtn = headerSite.querySelector(".mobile-menu-btn");
        const headerEnd = headerSite.querySelector(".header-end");
        const overlay = document.querySelector(".overlay");
        const body = document.body;
        const serviceMenu = headerMenuSite.querySelector(".menu-service");
        const subMenu = headerMenuSite.querySelector(".sub-menu");

        // Функция для проверки ширины экрана
        const isMobileView = () => window.innerWidth < 1200;

        // Функция для блокировки/разблокировки скролла
        const toggleScrollLock = lock => {
            if (lock) {
                // Сохраняем текущую позицию скролла
                const scrollY = window.scrollY;
                body.style.position = "fixed";
                body.style.top = `-${scrollY}px`;
                body.style.width = "100%";
                body.style.overflow = "hidden";
            } else {
                // Восстанавливаем позицию скролла
                const scrollY = body.style.top;
                body.style.position = "";
                body.style.top = "";
                body.style.width = "";
                body.style.overflow = "";

                if (scrollY) {
                    window.scrollTo(0, parseInt(scrollY || "0") * -1);
                }
            }
        };

        // Функция для открытия/закрытия меню
        const toggleMobileMenu = () => {
            if (!isMobileView()) return;

            const isActive = mobileMenuBtn.classList.contains("active");

            if (!isActive) {
                // Открываем меню
                mobileMenuBtn.classList.add("active");
                headerMenuSite.classList.add("active");
                overlay.classList.add("active");
                headerEnd.classList.add("open-menu");
                toggleScrollLock(true);
            } else {
                // Закрываем меню
                mobileMenuBtn.classList.remove("active");
                headerMenuSite.classList.remove("active");
                overlay.classList.remove("active");
                headerEnd.classList.remove("open-menu");
                toggleScrollLock(false);
            }
        };

        // Обработчик клика на кнопку меню
        mobileMenuBtn.addEventListener("click", toggleMobileMenu);

        // Закрытие меню при клике на overlay
        if (overlay) {
            overlay.addEventListener("click", () => {
                if (isMobileView() && mobileMenuBtn.classList.contains("active")) {
                    toggleMobileMenu();
                }
            });
        }

        // Обработчик изменения размера окна
        let resizeTimeout;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Если меню открыто, а перешли на десктоп
                if (!isMobileView() && mobileMenuBtn.classList.contains("active")) {
                    mobileMenuBtn.classList.remove("active");
                    headerMenuSite.classList.remove("active");
                    overlay.classList.remove("active");
                    headerEnd.classList.remove("open-menu");
                    toggleScrollLock(false);
                }
            }, 250);
        });
        serviceMenu.querySelector("a").addEventListener("click", e => {
            e.preventDefault();
        });
        serviceMenu.addEventListener("click", e => {
            if (!isMobileView()) return;

            serviceMenu.classList.toggle("active");
            subMenu.classList.toggle("active");
        });
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
