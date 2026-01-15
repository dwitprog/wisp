/**
 * Инициализирует аккордеон для FAQ-блоков с использованием CSS Grid для плавной анимации
 *
 * @function initFAQAccordion
 * @exports initFAQAccordion
 *
 * @param {string} containerSelector - CSS-селектор контейнера с FAQ элементами
 * @default ".faq"
 *
 * @description
 * Функция превращает статический FAQ блок в интерактивный аккордеон:
 * - При клике на элемент .item раскрывается/закрывается его .content
 * - Использует CSS Grid для анимации высоты (grid-template-rows)
 * - Поддерживает плавную анимацию opacity и padding
 * - Автоматически сохраняет оригинальные отступы контента
 *
 * @example
 * // Базовая инициализация
 * initFAQAccordion();
 *
 * // Инициализация конкретного контейнера
 * initFAQAccordion('.faq-section');
 *
 * // Структура HTML должна соответствовать:
 * // <div class="faq">
 * //   <div class="item">
 * //     <div class="title">...</div>
 * //     <div class="content">
 * //       <p>Контент здесь</p>
 * //     </div>
 * //   </div>
 * // </div>
 *
 * @returns {void}
 */
export function initFAQAccordion(containerSelector = ".faq-accordion") {
    // Находим контейнер по указанному селектору
    const container = document.querySelector(containerSelector);

    // Если контейнер не найден, прекращаем выполнение
    if (!container) {
        console.warn(`FAQ аккордеон: контейнер не найден (${containerSelector})`);
        return;
    }

    // Находим все элементы FAQ внутри контейнера
    const items = container.querySelectorAll(".item");

    /**
     * Инициализация всех FAQ элементов
     * Устанавливает начальное состояние (закрытое) для каждого элемента
     */
    items.forEach(item => {
        const content = item.querySelector(".content");
        if (!content) return;

        // Сохраняем оригинальные значения padding для восстановления при открытии
        const style = window.getComputedStyle(content);
        content.dataset.paddingTop = style.paddingTop;
        content.dataset.paddingBottom = style.paddingBottom;

        // Настраиваем CSS Grid для анимации высоты
        // grid-template-rows: 0fr - элемент скрыт (нулевая высота)
        content.style.display = "grid";
        content.style.gridTemplateRows = "0fr";

        // Настраиваем плавную анимацию для всех свойств
        content.style.transition = "grid-template-rows 0.5s ease, opacity 0.5s ease";
        content.style.opacity = "0";

        // В закрытом состоянии убираем отступы
        content.style.paddingTop = "0";
        content.style.paddingBottom = "0";

        /**
         * Важная настройка для корректной работы CSS Grid анимации:
         * - Устанавливаем min-height: 0 для предотвращения минимальной высоты контента
         * - overflow: hidden для скрытия контента при анимации
         */
        const innerContent = content.firstElementChild;
        if (innerContent) {
            innerContent.style.overflow = "hidden";
            innerContent.style.minHeight = "0";
        }

        // Помечаем элемент как закрытый
        item.classList.add("closed");
    });

    /**
     * Обработчик кликов по контейнеру (делегирование событий)
     * Обрабатывает клики по .item элементам внутри контейнера
     */
    container.addEventListener("click", e => {
        // Находим ближайший родительский элемент .item от места клика
        const item = e.target.closest(".item");

        // Проверяем, что клик был внутри контейнера и на элементе .item
        if (!item || !container.contains(item)) return;

        const content = item.querySelector(".content");
        if (!content) return;

        // Определяем текущее состояние элемента
        const isOpen = item.classList.contains("open");

        // Переключаем состояние
        if (isOpen) {
            closeItem(item, content);
        } else {
            openItem(item, content);
        }
    });

    /**
     * Открывает FAQ элемент
     *
     * @param {HTMLElement} item - DOM элемент .item
     * @param {HTMLElement} content - DOM элемент .content внутри item
     *
     * @description
     * 1. Восстанавливает оригинальные отступы
     * 2. Анимирует grid-template-rows от 0fr до 1fr
     * 3. Анимирует opacity от 0 до 1
     * 4. Обновляет CSS-классы состояния
     */
    function openItem(item, content) {
        // Восстанавливаем сохраненные значения отступов
        content.style.paddingTop = content.dataset.paddingTop;
        content.style.paddingBottom = content.dataset.paddingBottom;

        // Анимируем раскрытие через изменение grid-template-rows
        // 1fr означает "занять все доступное пространство"
        content.style.gridTemplateRows = "1fr";
        content.style.opacity = "1";

        // Обновляем классы для отслеживания состояния
        item.classList.remove("closed");
        item.classList.add("open");
    }

    /**
     * Закрывает FAQ элемент
     *
     * @param {HTMLElement} item - DOM элемент .item
     * @param {HTMLElement} content - DOM элемент .content внутри item
     *
     * @description
     * 1. Анимирует grid-template-rows от 1fr до 0fr
     * 2. Анимирует opacity от 1 до 0
     * 3. Убирает отступы для плавного скрытия
     * 4. Обновляет CSS-классы состояния
     */
    function closeItem(item, content) {
        // Анимируем закрытие
        content.style.gridTemplateRows = "0fr";
        content.style.opacity = "0";

        // Убираем отступы при закрытии
        content.style.paddingTop = "0";
        content.style.paddingBottom = "0";

        // Обновляем классы состояния
        item.classList.remove("open");
        item.classList.add("closed");
    }
}
