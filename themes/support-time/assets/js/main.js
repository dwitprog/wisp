"use strict";

/******************************
 *
 *******************************/

/* import Libs */
import LazyLoad from "vanilla-lazyload";
import { changeFontSize } from "./components/changeFontSize";
import { initFeedbackForm } from "./components/initFeedbackForm";
import { gsap } from "gsap";

document.addEventListener("DOMContentLoaded", () => {
    const ensureAutocompleteGuards = form => {
        if (!form || form.dataset.autocompleteGuarded) return;
        form.dataset.autocompleteGuarded = "true";

        const guardWrap = document.createElement("div");
        guardWrap.className = "autocomplete-guard";
        guardWrap.setAttribute("aria-hidden", "true");
        guardWrap.style.position = "absolute";
        guardWrap.style.left = "-9999px";
        guardWrap.style.width = "1px";
        guardWrap.style.height = "1px";
        guardWrap.style.overflow = "hidden";

        const guardUser = document.createElement("input");
        guardUser.type = "text";
        guardUser.name = "fake-username";
        guardUser.autocomplete = "username";
        guardUser.tabIndex = -1;

        const guardPass = document.createElement("input");
        guardPass.type = "password";
        guardPass.name = "fake-password";
        guardPass.autocomplete = "new-password";
        guardPass.tabIndex = -1;

        guardWrap.append(guardUser, guardPass);
        form.prepend(guardWrap);
    };

    const shouldRenameForAutocomplete = field => {
        if (!field || field.dataset.autofillRenamed === "true") return false;
        const name = field.getAttribute("name");
        if (!name) return false;
        if (field.hasAttribute("data-no-autofill-rename")) return false;

        if (field.tagName === "INPUT") {
            const type = (field.getAttribute("type") || "text").toLowerCase();
            const skipTypes = [
                "checkbox",
                "radio",
                "submit",
                "button",
                "image",
                "file",
                "hidden",
                "range",
                "color",
                "reset",
            ];
            return !skipTypes.includes(type);
        }

        return field.tagName === "TEXTAREA";
    };

    const renameForAutocomplete = (field, index) => {
        if (!shouldRenameForAutocomplete(field)) return;
        const originalName = field.getAttribute("name");
        if (!field.dataset.originalName) {
            field.dataset.originalName = originalName;
        }
        if (!field.dataset.field) {
            field.dataset.field = originalName;
        }
        const uniqueSuffix = `${Date.now().toString(36)}_${index}_${Math.random().toString(36).slice(2, 6)}`;
        field.setAttribute("name", `af_${originalName}_${uniqueSuffix}`);
        field.dataset.autofillRenamed = "true";
    };

    const disableAutocomplete = root => {
        const container = root || document;
        const fields = container.querySelectorAll("input, textarea, select");
        fields.forEach((field, index) => {
            field.setAttribute("autocomplete", "new-password");
            field.setAttribute("autocorrect", "off");
            field.setAttribute("autocapitalize", "off");
            field.setAttribute("spellcheck", "false");
            field.setAttribute("data-lpignore", "true");
            field.setAttribute("data-1p-ignore", "true");
            field.setAttribute("data-bwignore", "true");
            field.setAttribute("data-form-type", "other");

            if (field.tagName === "INPUT") {
                const type = (field.getAttribute("type") || "text").toLowerCase();
                const skipTypes = [
                    "checkbox",
                    "radio",
                    "submit",
                    "button",
                    "image",
                    "file",
                    "hidden",
                    "range",
                    "color",
                ];
                if (!skipTypes.includes(type) && !field.dataset.autocompleteLocked) {
                    field.dataset.autocompleteLocked = "true";
                    field.setAttribute("readonly", "readonly");
                    field.addEventListener(
                        "focus",
                        () => {
                            field.removeAttribute("readonly");
                        },
                        { once: true },
                    );
                }
            }

            renameForAutocomplete(field, index);
        });
        const forms = container.querySelectorAll("form");
        forms.forEach(form => {
            form.setAttribute("autocomplete", "off");
            ensureAutocompleteGuards(form);
        });
    };

    disableAutocomplete();
    setTimeout(disableAutocomplete, 300);
    setTimeout(disableAutocomplete, 1500);

    document.addEventListener("focusin", event => {
        const target = event.target;
        if (target && target.matches("input, textarea, select")) {
            disableAutocomplete(target.closest("form") || document);
        }
    });

    document.addEventListener(
        "submit",
        event => {
            const form = event.target;
            if (!form || form.tagName !== "FORM") return;
            const renamedFields = form.querySelectorAll("[data-original-name]");
            renamedFields.forEach(field => {
                const originalName = field.dataset.originalName;
                if (originalName) {
                    field.setAttribute("name", originalName);
                }
                delete field.dataset.autofillRenamed;
            });
            setTimeout(() => disableAutocomplete(form), 0);
        },
        true,
    );

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

    /* Открытие popup по data-pop и блокировка скролла */
    const toggleScrollLock = lock => {
        if (lock) {
            const scrollY = window.scrollY;
            document.body.style.position = "fixed";
            document.body.style.top = `-${scrollY}px`;
            document.body.style.width = "100%";
            document.body.style.overflow = "hidden";
            document.body.dataset.scrollY = String(scrollY);
        } else {
            const scrollY = Number(document.body.dataset.scrollY || 0);
            document.body.style.position = "";
            document.body.style.top = "";
            document.body.style.width = "";
            document.body.style.overflow = "";
            document.body.removeAttribute("data-scroll-y");
            window.scrollTo(0, scrollY);
        }
    };

    const openPopupButtons = document.querySelectorAll(".openPopup[data-pop]");
    if (openPopupButtons.length) {
        openPopupButtons.forEach(button => {
            button.addEventListener("click", event => {
                event.preventDefault();
                const popupId = button.getAttribute("data-pop");
                if (!popupId) return;
                const popup = document.getElementById(popupId);
                if (!popup) return;
                popup.classList.add("active");
                toggleScrollLock(true);
            });
        });
    }

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
            if (!isMobileView()) return;
            e.preventDefault();
        });
        serviceMenu.addEventListener("click", e => {
            if (!isMobileView()) return;

            serviceMenu.classList.toggle("active");
            subMenu.classList.toggle("active");
        });

        // Переключаем вариант хедера в зависимости от data-header-theme
        const headerVariants = ["header-variant_1", "header-variant_2", "header-variant_3", "header-variant_4"];
        const headerThemeMap = {
            blur: "header-variant_1",
            gradient1: "header-variant_2",
            gradient2: "header-variant_3",
            white: "header-variant_4",
        };
        const defaultHeaderVariant = "header-variant_4";

        const applyHeaderVariant = variant => {
            headerSite.classList.remove(...headerVariants, "header-gradient");
            headerSite.classList.add(variant);
        };

        const getSectionHeaderVariant = element => {
            const section = element?.closest("section");
            const themeKey = section?.getAttribute("data-header-theme");
            return headerThemeMap[themeKey] || defaultHeaderVariant;
        };

        let scheduled = false;
        const updateHeaderTheme = () => {
            scheduled = false;
            const probeX = Math.min(window.innerWidth / 2, window.innerWidth - 1);
            let probeY = Math.min(headerSite.offsetHeight + 1, window.innerHeight - 1);
            let target = document.elementFromPoint(probeX, probeY);

            if (target && headerSite.contains(target)) {
                probeY = Math.min(headerSite.offsetHeight + 20, window.innerHeight - 1);
                target = document.elementFromPoint(probeX, probeY);
            }
            if (!target) {
                return;
            }
            const variant = getSectionHeaderVariant(target);
            applyHeaderVariant(variant);
        };

        const scheduleUpdate = () => {
            if (scheduled) return;
            scheduled = true;
            requestAnimationFrame(updateHeaderTheme);
        };

        scheduleUpdate();
        window.addEventListener("scroll", scheduleUpdate, { passive: true });
        window.addEventListener("resize", scheduleUpdate);
    }

    /* Меняем дату на всем сайте внутри тегов с классом st-today-date */
    const stTodayDate = document.querySelectorAll(".st-today-date");
    if (stTodayDate.length > 0) {
        stTodayDate.forEach(el => {
            const now = new Date();
            el.innerText = now.getFullYear();
        });
    }

    const haveAQuestionsPopupForm = document.querySelector("#popupForm");
    if (haveAQuestionsPopupForm) {
        const formContent = haveAQuestionsPopupForm.querySelector("#popupForm .content");
        const afterSendContent = haveAQuestionsPopupForm.querySelector("#popupForm  .after-send");
        const btnSubmit = haveAQuestionsPopupForm.querySelector("#popupForm .btn-send");
        const closeButtons = haveAQuestionsPopupForm.querySelectorAll(".close-popup, .btn-close");
        let closeTimeoutId = null;

        const clearPopupInputs = () => {
            const fields = haveAQuestionsPopupForm.querySelectorAll(
                ".have-a-questions input, .have-a-questions textarea",
            );
            fields.forEach(field => {
                const type = field.getAttribute("type");
                if (type === "checkbox" || type === "radio") {
                    field.checked = false;
                } else {
                    field.value = "";
                }
            });
        };

        const resetPopupState = () => {
            if (closeTimeoutId) {
                clearTimeout(closeTimeoutId);
                closeTimeoutId = null;
            }
            if (formContent) {
                formContent.classList.remove("send-ok");
                gsap.set(formContent, { clearProps: "opacity,visibility" });
            }
            if (afterSendContent) {
                afterSendContent.classList.remove("active");
                gsap.set(afterSendContent, { clearProps: "opacity,visibility,display" });
            }
        };

        const closePopup = () => {
            resetPopupState();
            clearPopupInputs();
            haveAQuestionsPopupForm.classList.remove("active");
            toggleScrollLock(false);
        };

        closeButtons.forEach(button => {
            button.addEventListener("click", closePopup);
        });

        haveAQuestionsPopupForm.addEventListener("click", event => {
            const formContainer = haveAQuestionsPopupForm.querySelector(".have-a-questions");
            if (formContainer && !formContainer.contains(event.target)) {
                closePopup();
            }
        });
        initFeedbackForm("#popupForm .have-a-questions", {
            validateFields: {
                name: { required: true, selector: 'input[name="name"]' },
                email: { required: true, email: true, selector: 'input[name="email"]' },
                price: {
                    required: true,
                    selector: ".select-services-price",
                    customSelect: true,
                    messages: {
                        required: "Please select at least one service",
                    },
                },
                services: {
                    required: true,
                    selector: ".select-services",
                    customSelect: true,
                    messages: {
                        required: "Please select at least one service",
                    },
                },
            },
            showSuccessMessage: false,
            callbacks: {
                beforeSubmit: () => {
                    if (btnSubmit) btnSubmit.setAttribute("disabled", "disabled");
                },
                onSubmit: formData => {
                    const ajaxUrl = window.rgData?.ajax_url;
                    const ajaxNonce = window.rgData?.ajax_nonce;

                    if (!ajaxUrl || !ajaxNonce) {
                        return Promise.reject(new Error("Missing ajax config"));
                    }

                    const payload = new URLSearchParams();
                    payload.append("action", "st_send_form");
                    payload.append("nonce", ajaxNonce);
                    payload.append("page_url", window.location.href);

                    Object.entries(formData).forEach(([key, value]) => {
                        if (Array.isArray(value)) {
                            value.forEach(entry => payload.append(key, entry));
                        } else {
                            payload.append(key, value);
                        }
                    });

                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 20000);

                    return fetch(ajaxUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                        },
                        body: payload.toString(),
                        signal: controller.signal,
                    })
                        .then(response => {
                            clearTimeout(timeoutId);
                            if (!response.ok) {
                                throw new Error("Request failed");
                            }
                            return response.json();
                        })
                        .then(result => {
                            if (!result?.success) {
                                throw new Error(result?.data?.message || "Mail error");
                            }
                            if (formContent) {
                                formContent.classList.add("send-ok");
                            }
                            if (afterSendContent) {
                                afterSendContent.classList.add("active");
                            }
                            return result;
                        })
                        .catch(err => {
                            clearTimeout(timeoutId);
                            throw err;
                        });
                },
                onSuccess: () => {
                    if (btnSubmit) btnSubmit.removeAttribute("disabled");
                    if (formContent) {
                        gsap.to(formContent, {
                            autoAlpha: 0,
                            duration: 0.35,
                            ease: "power1.out",
                        });
                    }

                    if (afterSendContent) {
                        gsap.set(afterSendContent, { display: "flex" });
                        gsap.fromTo(
                            afterSendContent,
                            { autoAlpha: 0 },
                            {
                                autoAlpha: 1,
                                duration: 0.4,
                                ease: "power1.out",
                            },
                        );
                    }

                    closeTimeoutId = setTimeout(() => {
                        closePopup();
                        toggleScrollLock(false);
                    }, 5000);
                },
                onError: () => {
                    if (btnSubmit) btnSubmit.removeAttribute("disabled");
                },
            },
        });
    }
});
