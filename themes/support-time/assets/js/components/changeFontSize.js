export const changeFontSize = () => {
    const fontSizeInput = document.getElementById("fontSize");
    const thumb = document.querySelector(".changing-font-size_thumb");
    const line = document.querySelector(".changing-font-size_line");
    const container = document.querySelector(".changing-font-size_container");
    const wrapper = document.querySelector(".changing-font-size_wrapper");
    const toggleBtn = document.querySelector(".changing-font-size__btn");

    if (!fontSizeInput || !thumb || !line || !container || !wrapper || !toggleBtn) {
        console.error("Не все необходимые элементы найдены");
        return;
    }

    // Настройки - изменяем на проценты
    const minPercent = 100; // Минимум 100%
    const maxPercent = 150; // Максимум 150%

    // Устанавливаем атрибуты
    fontSizeInput.min = minPercent;
    fontSizeInput.max = maxPercent;
    fontSizeInput.value = minPercent;

    // Функция для обработки клика вне области wrapper
    function handleClickOutside(event) {
        // Проверяем, был ли клик внутри wrapper или на кнопке toggle
        const isClickInsideWrapper = wrapper.contains(event.target);
        const isClickOnToggleBtn = toggleBtn.contains(event.target);

        // Если клик был вне wrapper и не на кнопке toggle, закрываем wrapper
        if (!isClickInsideWrapper && !isClickOnToggleBtn && wrapper.classList.contains("active")) {
            wrapper.classList.remove("active");
            // Удаляем обработчик после закрытия
            document.removeEventListener("click", handleClickOutside);
        }
    }

    // Обработчик клика на кнопку toggle
    toggleBtn.addEventListener("click", event => {
        event.stopPropagation(); // Предотвращаем всплытие, чтобы handleClickOutside не сработал сразу
        wrapper.classList.toggle("active");

        if (wrapper.classList.contains("active")) {
            // Если wrapper открывается, добавляем обработчик клика вне области
            setTimeout(() => {
                document.addEventListener("click", handleClickOutside);
            }, 0);
        } else {
            // Если wrapper закрывается, удаляем обработчик
            document.removeEventListener("click", handleClickOutside);
        }
    });

    // Также закрываем wrapper при клике на сам wrapper (если нужно)
    wrapper.addEventListener("click", event => {
        event.stopPropagation(); // Предотвращаем всплытие к document
    });

    // Устанавливаем атрибуты
    fontSizeInput.min = minPercent;
    fontSizeInput.max = maxPercent;
    fontSizeInput.value = minPercent;

    // Базовые значения для расчета (100%)
    const baseValues = {
        headerMenuFontSize: 20, // Базовое значение для header#header.header .header-menu_list>.menu-item a
        headingFontSize: 64, // Базовое значение для .h1, .h2, h1, h2
        rootFontSize: 16, // Базовое значение для :root { --st-fs: 16px;}
        btnFontSize: 16, // Базовое значение для .btn
    };

    // Максимальные значения
    const maxValues = {
        headerMenuFontSize: 28,
        headingFontSize: 96,
        rootFontSize: 32,
        btnFontSize: 24,
    };

    // Исходные градиенты (для сохранения и восстановления)
    const originalGradient = "linear-gradient(134.15deg, #130839, #282251 36%, #793971 76%, #cc7897)";
    const simplifiedGradient = "linear-gradient(134.15deg, #130839, #4A2C5E)";

    // Кеш элементов с градиентами и их оригинальных значений
    let gradientElementsCache = null;

    // Функция для поиска элементов с градиентами и сохранения их оригинальных значений
    function findGradientElements() {
        if (gradientElementsCache) {
            return gradientElementsCache;
        }

        const elements = [];
        const allElements = document.querySelectorAll("*");

        allElements.forEach(el => {
            const computedStyle = window.getComputedStyle(el);
            const bgImage = computedStyle.backgroundImage;

            // Проверяем, содержит ли элемент исходный градиент (ищем по характерным цветам)
            if (bgImage && bgImage.includes("#130839") && bgImage.includes("#282251")) {
                // Сохраняем оригинальное значение из computedStyle
                const originalValue = bgImage;
                elements.push({
                    element: el,
                    originalGradient: originalValue
                });
            }
        });

        gradientElementsCache = elements;
        return elements;
    }

    // Функция для изменения градиентов
    function updateGradients(percent) {
        const shouldSimplify = percent > 100;
        const gradientElements = findGradientElements();

        gradientElements.forEach(({ element, originalGradient }) => {
            if (shouldSimplify) {
                // Применяем упрощенный градиент
                element.style.backgroundImage = simplifiedGradient;
            } else {
                // Восстанавливаем исходный градиент - удаляем инлайн стиль, чтобы вернулся CSS
                element.style.backgroundImage = "";
            }
        });
    }

    // Функция для пропорционального увеличения шрифтов
    function updateFontSizes(percent) {
        const multiplier = percent / 100;
        const isDefault = percent === 100;

        // 1. header#header.header .header-menu_list>.menu-item a (до 28px)
        const headerMenuItems = document.querySelectorAll("header#header.header .header-menu_list>.menu-item a");
        headerMenuItems.forEach(item => {
            if (isDefault) {
                item.style.fontSize = "";
            } else {
                const newSize = Math.min(baseValues.headerMenuFontSize * multiplier, maxValues.headerMenuFontSize);
                item.style.fontSize = `${newSize}px`;
            }
        });

        // 2. .h1, .h2, h1, h2 (до 96px)
        const headings = document.querySelectorAll(".h1, .h2, h1, h2");
        headings.forEach(heading => {
            if (isDefault) {
                heading.style.fontSize = "";
            } else {
                const newSize = Math.min(baseValues.headingFontSize * multiplier, maxValues.headingFontSize);
                heading.style.fontSize = `${newSize}px`;
            }
        });

        // 3. :root { --st-fs: } (до 32px)
        const root = document.documentElement;
        if (isDefault) {
            root.style.setProperty("--st-fs", "");
        } else {
            const newSize = Math.min(baseValues.rootFontSize * multiplier, maxValues.rootFontSize);
            root.style.setProperty("--st-fs", `${newSize}px`);
        }

        // 4. .btn (до 24px)
        const buttons = document.querySelectorAll(".btn");
        buttons.forEach(btn => {
            if (isDefault) {
                btn.style.fontSize = "";
            } else {
                const newSize = Math.min(baseValues.btnFontSize * multiplier, maxValues.btnFontSize);
                btn.style.fontSize = `${newSize}px`;
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
                // Возвращаем исходные стили
                if (offerTitle) {
                    offerTitle.style.border = "";
                    offerTitle.style.padding = "";
                }
                if (offerDesc) {
                    offerDesc.style.maxWidth = "";
                }
            } else {
                // Применяем новые стили
                if (offerTitle) {
                    offerTitle.style.border = "0px solid #fff";
                    offerTitle.style.padding = "19px 0";
                }
                if (offerDesc) {
                    offerDesc.style.maxWidth = "880px";
                }
            }
        }
    }

    // Функция обновления всех стилей
    function updateStyles(percent) {
        updateGradients(percent);
        updateFontSizes(percent);
        updatePage7BannerStyles(percent);
    }

    // Функция обновления позиции ползунка
    function updateThumbPosition(percent) {
        const lineWidth = line.offsetWidth;
        const thumbWidth = thumb.offsetWidth;
        const availableWidth = lineWidth - thumbWidth;

        // Рассчитываем позицию (процент → позиция)
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

        // Рассчитываем процент из позиции
        const percent = Math.round(minPercent + (boundedX / availableWidth) * (maxPercent - minPercent));

        thumb.style.left = `${boundedX}px`;
        fontSizeInput.value = percent;
        
        // Обновляем стили при изменении позиции
        updateStyles(percent);
    }

    // Обработчики событий
    fontSizeInput.addEventListener("input", function () {
        const percent = parseInt(this.value);
        updateThumbPosition(percent);
    });
    
    // Инициализация стилей при загрузке (устанавливаем базовые значения)
    updateStyles(minPercent);

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

            // Рассчитываем процент
            const percent = Math.round(minPercent + (newLeft / availableWidth) * (maxPercent - minPercent));

            thumb.style.left = `${newLeft}px`;
            fontSizeInput.value = percent;
            
            // Обновляем стили при перетаскивании
            updateStyles(percent);
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
};
