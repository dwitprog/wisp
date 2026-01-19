export const changeFontSize = () => {
    console.log("=== changeFontSize function called ===");
    
    const fontSizeInput = document.getElementById("fontSize");
    const thumb = document.querySelector(".changing-font-size_thumb");
    const line = document.querySelector(".changing-font-size_line");
    const container = document.querySelector(".changing-font-size_container");
    const wrapper = document.querySelector(".changing-font-size_wrapper");
    const toggleBtn = document.querySelector(".changing-font-size__btn");
    
    console.log("Elements found:", {
        fontSizeInput: !!fontSizeInput,
        thumb: !!thumb,
        line: !!line,
        container: !!container,
        wrapper: !!wrapper,
        toggleBtn: !!toggleBtn
    });

    if (!fontSizeInput || !thumb || !line || !container || !wrapper) {
        console.error("Не все необходимые элементы найдены", {
            fontSizeInput: !!fontSizeInput,
            thumb: !!thumb,
            line: !!line,
            container: !!container,
            wrapper: !!wrapper,
            toggleBtn: !!toggleBtn
        });
        return;
    }
    
    console.log("changeFontSize initialized successfully", {
        fontSizeInput: !!fontSizeInput,
        thumb: !!thumb,
        line: !!line,
        container: !!container,
        wrapper: !!wrapper,
        toggleBtn: !!toggleBtn
    });

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
        const isClickOnToggleBtn = toggleBtn ? toggleBtn.contains(event.target) : false;

        // Если клик был вне wrapper и не на кнопке toggle, закрываем wrapper
        if (!isClickInsideWrapper && !isClickOnToggleBtn && wrapper.classList.contains("active")) {
            wrapper.classList.remove("active");
            // Удаляем обработчик после закрытия
            document.removeEventListener("click", handleClickOutside);
        }
    }

    // Обработчик клика на кнопку toggle (если есть)
    if (toggleBtn) {
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
    }

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
        // Сбрасываем кеш при каждом обновлении для более точного поиска
        gradientElementsCache = null;
        const gradientElements = findGradientElements();

        console.log(`Gradient elements found: ${gradientElements.length}, shouldSimplify: ${shouldSimplify}`);

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

    // Функция для получения текущего размера шрифта элемента
    function getCurrentFontSize(element) {
        const computedStyle = window.getComputedStyle(element);
        const fontSize = parseFloat(computedStyle.fontSize);
        return fontSize || 16; // Fallback
    }

    // Функция для пропорционального увеличения шрифтов
    function updateFontSizes(percent) {
        const multiplier = percent / 100;
        const isDefault = percent === 100;

        // 1. header#header.header .header-menu_list>.menu-item a (до 28px)
        const headerMenuItems = document.querySelectorAll("header#header.header .header-menu_list>.menu-item a");
        console.log('Header menu items found:', headerMenuItems.length);
        headerMenuItems.forEach(item => {
            if (isDefault) {
                item.style.removeProperty("font-size");
            } else {
                // Получаем текущий размер или используем базовый
                const currentSize = getCurrentFontSize(item) || baseValues.headerMenuFontSize;
                const baseSize = baseValues.headerMenuFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.headerMenuFontSize);
                item.style.setProperty("font-size", `${newSize}px`, "important");
                console.log(`Header menu: ${currentSize}px -> ${newSize}px`);
            }
        });

        // 2. .h1, .h2, h1, h2 (до 96px)
        const headings = document.querySelectorAll(".h1, .h2, h1, h2");
        console.log('Headings found:', headings.length);
        headings.forEach(heading => {
            if (isDefault) {
                heading.style.removeProperty("font-size");
            } else {
                const currentSize = getCurrentFontSize(heading) || baseValues.headingFontSize;
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
            // Получаем текущее значение CSS переменной или используем базовое
            const currentVar = getComputedStyle(root).getPropertyValue("--st-fs").trim();
            const currentSize = currentVar ? parseFloat(currentVar) : baseValues.rootFontSize;
            const baseSize = baseValues.rootFontSize;
            const newSize = Math.min(baseSize * multiplier, maxValues.rootFontSize);
            root.style.setProperty("--st-fs", `${newSize}px`);
            console.log(`Root --st-fs: ${currentSize}px -> ${newSize}px`);
        }

        // 4. .btn (до 24px)
        const buttons = document.querySelectorAll(".btn");
        console.log('Buttons found:', buttons.length);
        buttons.forEach(btn => {
            if (isDefault) {
                btn.style.removeProperty("font-size");
            } else {
                const currentSize = getCurrentFontSize(btn) || baseValues.btnFontSize;
                const baseSize = baseValues.btnFontSize;
                const newSize = Math.min(baseSize * multiplier, maxValues.btnFontSize);
                btn.style.setProperty("font-size", `${newSize}px`, "important");
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
                    offerTitle.style.removeProperty("border");
                    offerTitle.style.removeProperty("padding");
                }
                if (offerDesc) {
                    offerDesc.style.removeProperty("max-width");
                }
            } else {
                // Применяем новые стили
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
        console.log('Updating styles for percent:', percent);
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

        // Используем updateThumbPosition для обновления
        updateThumbPosition(percent);
    }

    // Обработчики событий
    fontSizeInput.addEventListener("input", function () {
        const percent = parseInt(this.value);
        console.log('Input event triggered, value:', percent);
        updateThumbPosition(percent);
    });
    
    // Также слушаем событие change для надежности
    fontSizeInput.addEventListener("change", function () {
        const percent = parseInt(this.value);
        console.log('Change event triggered, value:', percent);
        updateThumbPosition(percent);
    });
    
    // Инициализация стилей при загрузке (устанавливаем базовые значения)
    console.log('Initializing font size changer with default percent:', minPercent);
    updateStyles(minPercent);
    
    console.log('Font size changer initialized successfully');

    thumb.addEventListener("mousedown", function (e) {
        e.preventDefault();
        console.log('Thumb mousedown event');

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
            console.log('Mouse move, updating styles for percent:', percent);
            updateThumbPosition(percent); // Используем эту функцию для обновления
        }

        function onMouseUp() {
            console.log('Mouse up');
            document.removeEventListener("mousemove", onMouseMove);
            document.removeEventListener("mouseup", onMouseUp);
        }

        document.addEventListener("mousemove", onMouseMove);
        document.addEventListener("mouseup", onMouseUp);
    });

    line.addEventListener("click", function (e) {
        console.log('Line click event');
        updateFromPosition(e.clientX);
    });
    
    // Проверяем, что обработчики привязаны
    console.log('Event listeners attached:', {
        input: fontSizeInput.oninput !== null || fontSizeInput.attributes.oninput,
        change: fontSizeInput.onchange !== null || fontSizeInput.attributes.onchange,
        thumbMousedown: thumb.onmousedown !== null || thumb.attributes.onmousedown
    });
    
    // Также добавляем прямой обработчик на изменение value через setInterval для надежности
    let lastValue = parseInt(fontSizeInput.value);
    setInterval(() => {
        const currentValue = parseInt(fontSizeInput.value);
        if (currentValue !== lastValue) {
            console.log('Value changed via setInterval:', currentValue);
            lastValue = currentValue;
            updateThumbPosition(currentValue);
        }
    }, 100); // Проверяем каждые 100мс
};
