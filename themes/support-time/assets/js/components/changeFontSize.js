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

    // Функция обновления позиции ползунка
    function updateThumbPosition(percent) {
        const lineWidth = line.offsetWidth;
        const thumbWidth = thumb.offsetWidth;
        const availableWidth = lineWidth - thumbWidth;

        // Рассчитываем позицию (процент → позиция)
        const position = ((percent - minPercent) / (maxPercent - minPercent)) * availableWidth;

        thumb.style.left = `${position}px`;
        fontSizeInput.value = percent;
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
    }

    // Обработчики событий
    fontSizeInput.addEventListener("input", function () {
        updateThumbPosition(parseInt(this.value));
    });

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
