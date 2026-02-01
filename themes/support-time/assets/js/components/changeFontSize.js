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

    // Настройки - изменяем на проценты (небольшое увеличение, чтобы верстка не ломалась)
    const minPercent = 100; // Минимум 100%
    const maxPercent = 115; // Максимум 115% (~15% увеличение)

    // Ключ для localStorage
    const STORAGE_KEY = "fontSizePercent";

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
                    syncThumbPosition(parseInt(fontSizeInput.value));
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

    // Функция обновления стилей через класс .highglass и CSS переменную
    function updateStyles(percent) {
        const isDefault = percent === 100;
        const body = document.body;
        const root = document.documentElement;

        const multiplier = percent / 100;

        if (isDefault) {
            // Удаляем класс и CSS переменные
            body.classList.remove("highglass");
            root.style.removeProperty("--font-size-multiplier");
            root.style.removeProperty("--st-fs");
        } else {
            // Добавляем класс и устанавливаем CSS переменные
            body.classList.add("highglass");
            root.style.setProperty("--font-size-multiplier", multiplier.toString());
            // Устанавливаем переменную --st-fs с максимальным ограничением
            const baseRootSize = 16;
            const maxRootSize = 32;
            const newRootSize = Math.min(baseRootSize * multiplier, maxRootSize);
            root.style.setProperty("--st-fs", `${newRootSize}px`);
        }

        // Уведомляем другие модули (например, слайдер на /services/) о смене режима шрифта
        window.dispatchEvent(new CustomEvent("highglasschange", { detail: { highglass: !isDefault } }));

        // Сохраняем состояние
        saveState(percent);
    }

    // Синхронизация только визуальной позиции ползунка (без вызова updateStyles)
    function syncThumbPosition(percent) {
        const lineWidth = line.offsetWidth;
        const thumbWidth = thumb.offsetWidth;
        const availableWidth = lineWidth - thumbWidth;
        if (availableWidth <= 0) return;
        const position = ((percent - minPercent) / (maxPercent - minPercent)) * availableWidth;
        thumb.style.left = `${position}px`;
        fontSizeInput.value = percent;
    }

    // Функция обновления позиции ползунка
    function updateThumbPosition(percent) {
        syncThumbPosition(percent);
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
    updateStyles(savedPercent);
    requestAnimationFrame(() => {
        requestAnimationFrame(() => syncThumbPosition(savedPercent));
    });
    window.addEventListener("resize", () => syncThumbPosition(parseInt(fontSizeInput.value)));

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

    function getClientX(e) {
        return e.touches ? e.touches[0].clientX : e.clientX;
    }

    thumb.addEventListener(
        "touchstart",
        function (e) {
            e.preventDefault();
            const startX = getClientX(e);
            const startLeft = parseFloat(thumb.style.left) || 0;

            function onTouchMove(ev) {
                ev.preventDefault();
                const currentX = getClientX(ev);
                const deltaX = currentX - startX;
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

            function onTouchEnd() {
                document.removeEventListener("touchmove", onTouchMove, { passive: false });
                document.removeEventListener("touchend", onTouchEnd);
            }

            document.addEventListener("touchmove", onTouchMove, { passive: false });
            document.addEventListener("touchend", onTouchEnd);
        },
        { passive: false },
    );

    line.addEventListener(
        "touchstart",
        function (e) {
            if (e.touches && e.touches.length) {
                e.preventDefault();
                updateFromPosition(getClientX(e));
            }
        },
        { passive: false },
    );

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
