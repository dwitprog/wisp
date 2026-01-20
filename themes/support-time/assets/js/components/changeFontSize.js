export const changeFontSize = () => {
    const fontSizeInput = document.getElementById("fontSize");
    const thumb = document.querySelector(".changing-font-size_thumb");
    const line = document.querySelector(".changing-font-size_line");
    const container = document.querySelector(".changing-font-size_container");
    const wrapper = document.querySelector(".changing-font-size_wrapper");
    const toggleBtn = document.querySelector(".changing-font-size__btn");

    if (!fontSizeInput || !thumb || !line || !container || !wrapper) {
        return;
    }

    // Настройки - изменяем на проценты
    const minPercent = 100; // Минимум 100%
    const maxPercent = 150; // Максимум 150%

    // Ключ для localStorage
    const STORAGE_KEY = 'fontSizePercent';

    // Функция для сохранения состояния
    function saveState(percent) {
        try {
            localStorage.setItem(STORAGE_KEY, percent.toString());
        } catch (e) {
            // Игнорируем ошибки localStorage
        }
    }

    // Функция для загрузки состояния
    function loadState() {
        try {
            const saved = localStorage.getItem(STORAGE_KEY);
            if (saved) {
                const percent = parseInt(saved);
                if (percent >= minPercent && percent <= maxPercent) {
                    return percent;
                }
            }
        } catch (e) {
            // Игнорируем ошибки localStorage
        }
        return minPercent;
    }

    // Устанавливаем атрибуты
    fontSizeInput.min = minPercent;
    fontSizeInput.max = maxPercent;
    
    // Загружаем сохраненное значение
    const savedPercent = loadState();
    fontSizeInput.value = savedPercent;

    // Функция для обработки клика вне области wrapper
    function handleClickOutside(event) {
        const isClickInsideWrapper = wrapper.contains(event.target);
        const isClickOnToggleBtn = toggleBtn ? toggleBtn.contains(event.target) : false;

        if (!isClickInsideWrapper && !isClickOnToggleBtn && wrapper.classList.contains("active")) {
            wrapper.classList.remove("active");
            document.removeEventListener("click", handleClickOutside);
        }
    }

    // Обработчик клика на кнопку toggle (если есть)
    if (toggleBtn) {
        toggleBtn.addEventListener("click", event => {
            event.stopPropagation();
            wrapper.classList.toggle("active");

            if (wrapper.classList.contains("active")) {
                setTimeout(() => {
                    document.addEventListener("click", handleClickOutside);
                }, 0);
            } else {
                document.removeEventListener("click", handleClickOutside);
            }
        });
    }

    // Также закрываем wrapper при клике на сам wrapper (если нужно)
    wrapper.addEventListener("click", event => {
        event.stopPropagation();
    });

    // Базовые значения для расчета (100%)
    const baseValues = {
        headerMenuFontSize: 20,
        headingFontSize: 64,
        rootFontSize: 16,
        btnFontSize: 16,
        footerFontSize: 10,
        pFontSize: 16, // теги p
        servicesItemTitle: 32, // .page-7.services .list .item .title
        servicesItemActiveTitle: 56, // .page-7.services .list .item.active .title
        projectStagesItemTitle: 48, // .project-stages .items .item .title
        haveQuestionsInput: 40, // .have-a-questions .form .input-wrapper input
        faqItemTitle: 40, // .page-7.faq .items .item .title
        faqItemActiveTitle: 64, // .page-7.faq .items .item.active .title
    };

    // Максимальные значения
    const maxValues = {
        headerMenuFontSize: 28,
        headingFontSize: 96,
        rootFontSize: 32,
        btnFontSize: 24,
        footerFontSize: 20,
        pFontSize: 32,
        servicesItemTitle: 40,
        servicesItemActiveTitle: 70,
        projectStagesItemTitle: 56,
        haveQuestionsInput: 48,
        faqItemTitle: 48,
        faqItemActiveTitle: 80,
    };

    // Исходные градиенты (для сохранения и восстановления)
    const originalGradient = "linear-gradient(134.15deg, #130839, #282251 36%, #793971 76%, #cc7897)";
    const simplifiedGradient = "linear-gradient(134.15deg, #130839, #4A2C5E)";
    const specialGradient = "linear-gradient(182deg, rgb(19, 8, 57), #282251)"; // Для .page-7.platforms и .have-a-questions .content

    // Функция для изменения градиентов по точным селекторам
    function updateGradients(percent) {
        const shouldSimplify = percent > 100;

        // .page-7.banner и .page-7.faq - упрощенный градиент
        const simpleGradientSelectors = [
            ".page-7.banner",
            ".page-7.faq",
        ];

        simpleGradientSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                if (shouldSimplify) {
                    el.style.setProperty("background-image", simplifiedGradient, "important");
                } else {
                    el.style.removeProperty("background-image");
                }
            });
        });

        // .page-7.platforms и .have-a-questions .content - специальный градиент
        const specialGradientSelectors = [
            ".page-7.platforms",
            ".have-a-questions .content",
        ];

        specialGradientSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
                if (shouldSimplify) {
                    el.style.setProperty("background-image", specialGradient, "important");
                } else {
                    el.style.removeProperty("background-image");
                }
            });
        });

        // Обрабатываем псевдоэлемент :before для .page-7.faq
        const faqElement = document.querySelector(".page-7.faq");
        if (faqElement) {
            let style = document.getElementById("font-size-changer-faq-before");
            
            if (!style) {
                style = document.createElement("style");
                style.id = "font-size-changer-faq-before";
                document.head.appendChild(style);
            }

            if (shouldSimplify) {
                style.textContent = `.page-7.faq:before { background-image: ${simplifiedGradient} !important; background: #130839 !important; }`;
            } else {
                style.textContent = "";
            }
        }
    }

    // Функция для получения текущего размера шрифта элемента
    function getCurrentFontSize(element) {
        const computedStyle = window.getComputedStyle(element);
        const fontSize = parseFloat(computedStyle.fontSize);
        return fontSize || 16;
    }

    // Функция для пропорционального увеличения шрифтов
    function updateFontSizes(percent) {
        const multiplier = percent / 100;
        const isDefault = percent === 100;

        // 1. header#header.header .header-menu_list>.menu-item a (до 28px)
        const headerMenuItems = document.querySelectorAll("header#header.header .header-menu_list>.menu-item a");
        headerMenuItems.forEach(item => {
            if (isDefault) {
                item.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.headerMenuFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.headerMenuFontSize);
                item.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 2. .h1, .h2, h1, h2 (до 96px)
        const headings = document.querySelectorAll(".h1, .h2, h1, h2");
        headings.forEach(heading => {
            if (isDefault) {
                heading.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.headingFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.headingFontSize);
                heading.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 3. :root { --st-fs: } (до 32px)
        const root = document.documentElement;
        if (isDefault) {
            root.style.setProperty("--st-fs", "");
        } else {
            const baseSize = baseValues.rootFontSize;
            const newSize = Math.min(baseSize * multiplier, maxValues.rootFontSize);
            root.style.setProperty("--st-fs", `${newSize}px`);
        }

        // 4. .btn (до 24px)
        const buttons = document.querySelectorAll(".btn");
        buttons.forEach(btn => {
            if (isDefault) {
                btn.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.btnFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.btnFontSize);
                btn.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 5. footer.footer#footer .bottom a, footer.footer#footer .bottom p (до 20px, базовое 10px)
        const footerElements = document.querySelectorAll("footer.footer#footer .bottom a, footer.footer#footer .bottom p");
        footerElements.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.footerFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.footerFontSize);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 6. теги p (до 32px)
        const paragraphs = document.querySelectorAll("p");
        paragraphs.forEach(p => {
            if (isDefault) {
                p.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.pFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.pFontSize);
                p.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 7. .page-7.services .list .item .title (до 40px, базовое 32px)
        const servicesItemTitles = document.querySelectorAll(".page-7.services .list .item .title");
        servicesItemTitles.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.servicesItemTitle;
                const newSize = Math.min(baseSize * multiplier, maxValues.servicesItemTitle);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 8. .page-7.services .list .item.active .title (до 70px, базовое 56px)
        const servicesItemActiveTitles = document.querySelectorAll(".page-7.services .list .item.active .title");
        servicesItemActiveTitles.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.servicesItemActiveTitle;
                const newSize = Math.min(baseSize * multiplier, maxValues.servicesItemActiveTitle);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 9. .project-stages .items .item .title (до 56px, базовое 48px)
        const projectStagesItemTitles = document.querySelectorAll(".project-stages .items .item .title");
        projectStagesItemTitles.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.projectStagesItemTitle;
                const newSize = Math.min(baseSize * multiplier, maxValues.projectStagesItemTitle);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 10. .have-a-questions .form .input-wrapper input (до 48px, базовое 40px)
        const haveQuestionsInputs = document.querySelectorAll(".have-a-questions .form .input-wrapper input");
        haveQuestionsInputs.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.haveQuestionsInput;
                const newSize = Math.min(baseSize * multiplier, maxValues.haveQuestionsInput);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 11. .page-7.faq .items .item .title (до 48px, базовое 40px)
        const faqItemTitles = document.querySelectorAll(".page-7.faq .items .item .title");
        faqItemTitles.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.faqItemTitle;
                const newSize = Math.min(baseSize * multiplier, maxValues.faqItemTitle);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });

        // 12. .page-7.faq .items .item.active .title (до 80px, базовое 64px)
        const faqItemActiveTitles = document.querySelectorAll(".page-7.faq .items .item.active .title");
        faqItemActiveTitles.forEach(el => {
            if (isDefault) {
                el.style.removeProperty("font-size");
            } else {
                const baseSize = baseValues.faqItemActiveTitle;
                const newSize = Math.min(baseSize * multiplier, maxValues.faqItemActiveTitle);
                el.style.setProperty("font-size", `${newSize}px`, "important");
            }
        });
    }

    // Функция для обновления стилей header при увеличении шрифта
    function updateHeaderStyles(percent) {
        const isDefault = percent === 100;
        const headerEnd = document.querySelector("#header.header .header-end");
        const headerMenuList = document.querySelector("header#header.header .header-menu_list");
        const headerPhone = document.querySelector("#header.header .header-end .header-phone");
        const changingFontBtnSvg = document.querySelector(".changing-font-size__btn svg");

        if (isDefault) {
            if (headerEnd) {
                headerEnd.style.removeProperty("flex-wrap");
                headerEnd.style.removeProperty("max-width");
                headerEnd.style.removeProperty("justify-content");
                headerEnd.style.removeProperty("gap");
            }
            if (headerMenuList) {
                headerMenuList.style.removeProperty("gap");
            }
            if (headerPhone) {
                headerPhone.style.removeProperty("order");
            }
            if (changingFontBtnSvg) {
                changingFontBtnSvg.style.removeProperty("width");
                changingFontBtnSvg.style.removeProperty("height");
            }
        } else {
            if (headerEnd) {
                headerEnd.style.setProperty("flex-wrap", "wrap", "important");
                headerEnd.style.setProperty("max-width", "155px", "important");
                headerEnd.style.setProperty("justify-content", "center", "important");
                headerEnd.style.setProperty("gap", "12px", "important");
            }
            if (headerMenuList) {
                headerMenuList.style.setProperty("gap", "4px", "important");
            }
            if (headerPhone) {
                headerPhone.style.setProperty("order", "2", "important");
            }
            if (changingFontBtnSvg) {
                changingFontBtnSvg.style.setProperty("width", "45px", "important");
                changingFontBtnSvg.style.setProperty("height", "26px", "important");
            }
        }
    }

    // Функция для обновления дополнительных стилей при увеличении шрифта
    function updateAdditionalStyles(percent) {
        const isDefault = percent === 100;

        // .project-stages .items .item max-width: 738px
        const projectStagesItems = document.querySelectorAll(".project-stages .items .item");
        projectStagesItems.forEach(item => {
            if (isDefault) {
                item.style.removeProperty("max-width");
            } else {
                item.style.setProperty("max-width", "738px", "important");
            }
        });

        // .project-stages .items .item .desc max-width: 738px
        const projectStagesDescs = document.querySelectorAll(".project-stages .items .item .desc");
        projectStagesDescs.forEach(desc => {
            if (isDefault) {
                desc.style.removeProperty("max-width");
            } else {
                desc.style.setProperty("max-width", "738px", "important");
            }
        });

        // .have-a-questions .container max-width: 100%
        const haveQuestionsContainer = document.querySelector(".have-a-questions .container");
        if (haveQuestionsContainer) {
            if (isDefault) {
                haveQuestionsContainer.style.removeProperty("max-width");
            } else {
                haveQuestionsContainer.style.setProperty("max-width", "100%", "important");
            }
        }

        // .have-a-questions .subtitle opacity: .99
        const haveQuestionsSubtitle = document.querySelector(".have-a-questions .subtitle");
        if (haveQuestionsSubtitle) {
            if (isDefault) {
                haveQuestionsSubtitle.style.removeProperty("opacity");
            } else {
                haveQuestionsSubtitle.style.setProperty("opacity", ".99", "important");
            }
        }

        // .have-a-questions .content border-radius: 0
        const haveQuestionsContent = document.querySelector(".have-a-questions .content");
        if (haveQuestionsContent) {
            if (isDefault) {
                haveQuestionsContent.style.removeProperty("border-radius");
            } else {
                haveQuestionsContent.style.setProperty("border-radius", "0", "important");
            }
        }

        // .page-7.faq .section-title right: 10%
        const faqSectionTitle = document.querySelector(".page-7.faq .section-title");
        if (faqSectionTitle) {
            if (isDefault) {
                faqSectionTitle.style.removeProperty("right");
            } else {
                faqSectionTitle.style.setProperty("right", "10%", "important");
            }
        }

        // .page-7.platforms .section-title right: 10%
        const platformsSectionTitle = document.querySelector(".page-7.platforms .section-title");
        if (platformsSectionTitle) {
            if (isDefault) {
                platformsSectionTitle.style.removeProperty("right");
            } else {
                platformsSectionTitle.style.setProperty("right", "10%", "important");
            }
        }

        // .st-grid-column-lg-2 grid-template-columns: repeat(1, 1fr)
        const gridColumns = document.querySelectorAll(".st-grid-column-lg-2");
        gridColumns.forEach(grid => {
            if (isDefault) {
                grid.style.removeProperty("grid-template-columns");
            } else {
                grid.style.setProperty("grid-template-columns", "repeat(1, 1fr)", "important");
            }
        });

        // .page-7.platforms .items .item .desc max-width: 599px
        const platformsItemDescs = document.querySelectorAll(".page-7.platforms .items .item .desc");
        platformsItemDescs.forEach(desc => {
            if (isDefault) {
                desc.style.removeProperty("max-width");
            } else {
                desc.style.setProperty("max-width", "599px", "important");
            }
        });
    }

    // Функция для обновления стилей .page-7.banner
    function updatePage7BannerStyles(percent) {
        const isDefault = percent === 100;
        const page7Banner = document.querySelector(".page-7.banner");

        if (page7Banner) {
            const offerTitle = page7Banner.querySelector(".offer .title");
            const offerDesc = page7Banner.querySelector(".offer .desc");

            if (isDefault) {
                if (offerTitle) {
                    offerTitle.style.removeProperty("border");
                    offerTitle.style.removeProperty("padding");
                }
                if (offerDesc) {
                    offerDesc.style.removeProperty("max-width");
                }
            } else {
                if (offerTitle) {
                    offerTitle.style.setProperty("border", "0px solid #fff", "important");
                    offerTitle.style.setProperty("padding", "19px 0", "important");
                }
                if (offerDesc) {
                    offerDesc.style.setProperty("max-width", "880px", "important");
                }
            }
        }
    }

    // Функция обновления всех стилей
    function updateStyles(percent) {
        updateGradients(percent);
        updateFontSizes(percent);
        updateHeaderStyles(percent);
        updatePage7BannerStyles(percent);
        updateAdditionalStyles(percent);
        // Сохраняем состояние
        saveState(percent);
    }

    // Функция обновления позиции ползунка
    function updateThumbPosition(percent) {
        const lineWidth = line.offsetWidth;
        const thumbWidth = thumb.offsetWidth;
        const availableWidth = lineWidth - thumbWidth;

        const position = ((percent - minPercent) / (maxPercent - minPercent)) * availableWidth;

        thumb.style.left = `${position}px`;
        fontSizeInput.value = percent;
        
        // Обновляем стили при изменении позиции
        updateStyles(percent);
    }

    // Функция обновления из позиции мыши
    function updateFromPosition(clientX) {
        const containerRect = container.getBoundingClientRect();
        const lineWidth = line.offsetWidth;
        const thumbWidth = thumb.offsetWidth;
        const availableWidth = lineWidth - thumbWidth;

        const relativeX = clientX - containerRect.left - thumbWidth / 2;
        const boundedX = Math.max(0, Math.min(availableWidth, relativeX));

        const percent = Math.round(minPercent + (boundedX / availableWidth) * (maxPercent - minPercent));

        updateThumbPosition(percent);
    }

    // Обработчики событий
    fontSizeInput.addEventListener("input", function () {
        const percent = parseInt(this.value);
        updateThumbPosition(percent);
    });
    
    fontSizeInput.addEventListener("change", function () {
        const percent = parseInt(this.value);
        updateThumbPosition(percent);
    });
    
    // Инициализация стилей при загрузке с сохраненным значением
    updateThumbPosition(savedPercent);
    updateStyles(savedPercent);

    thumb.addEventListener("mousedown", function (e) {
        e.preventDefault();

        const startX = e.clientX;
        const startLeft = parseFloat(thumb.style.left) || 0;

        function onMouseMove(e) {
            const deltaX = e.clientX - startX;
            const lineWidth = line.offsetWidth;
            const thumbWidth = thumb.offsetWidth;
            const availableWidth = lineWidth - thumbWidth;

            let newLeft = startLeft + deltaX;
            newLeft = Math.max(0, Math.min(availableWidth, newLeft));

            const percent = Math.round(minPercent + (newLeft / availableWidth) * (maxPercent - minPercent));

            thumb.style.left = `${newLeft}px`;
            fontSizeInput.value = percent;
            
            updateThumbPosition(percent);
        }

        function onMouseUp() {
            document.removeEventListener("mousemove", onMouseMove);
            document.removeEventListener("mouseup", onMouseUp);
        }

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
    });

    line.addEventListener("click", function (e) {
        updateFromPosition(e.clientX);
    });
    
    // Polling для отслеживания изменений значения
    let lastValue = parseInt(fontSizeInput.value);
    setInterval(() => {
        const currentValue = parseInt(fontSizeInput.value);
        if (currentValue !== lastValue) {
            lastValue = currentValue;
            updateThumbPosition(currentValue);
        }
    }, 100);
};
