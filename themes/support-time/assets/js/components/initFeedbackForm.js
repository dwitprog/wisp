/**
 * Инициализация формы обратной связи с поддержкой кастомных селекторов, валидации и callback функций.
 *
 * Эта функция автоматически находит форму в указанном контейнере, инициализирует кастомные селекторы,
 * настраивает валидацию полей и обработку отправки формы. Поддерживает различные callback функции
 * для интеграции с внешними системами (AJAX, аналитика, модальные окна).
 *
 * @example
 * // Базовый пример использования
 * const feedbackForm = initFeedbackForm('.have-a-questions', {
 *     validateFields: {
 *         name: { required: true, selector: 'input[name="name"]' },
 *         email: { required: true, email: true, selector: 'input[name="email"]' },
 *         phone: {
 *             required: true,
 *             numeric: true, // Только цифры
 *             selector: 'input[name="phone"]',
 *             messages: {
 *                 numeric: "Please enter numbers only"
 *             }
 *         }
 *     }
 * });
 *
 * @param {string} [containerSelector=".have-a-questions"] - CSS селектор контейнера с формой.
 *                                                         По умолчанию ищет элемент с классом "have-a-questions".
 * @param {Object} [options={}] - Объект с настройками инициализации формы.
 *
 * @param {Object} [options.validateFields={}] - Конфигурация полей для валидации.
 *     Каждое поле представляет собой объект с настройками валидации.
 *
 *     @param {Object} options.validateFields.fieldName - Конфигурация конкретного поля.
 *         @param {string} options.validateFields.fieldName.selector - CSS селектор для поиска поля в форме.
 *         @param {boolean} [options.validateFields.fieldName.required=false] - Обязательность заполнения поля.
 *         @param {boolean} [options.validateFields.fieldName.email=false] - Валидация email формата.
 *         @param {boolean} [options.validateFields.fieldName.numeric=false] - Валидация только цифр (0-9).
 *         @param {number} [options.validateFields.fieldName.minLength] - Минимальная длина значения.
 *         @param {number} [options.validateFields.fieldName.maxLength] - Максимальная длина значения.
 *         @param {Object} [options.validateFields.fieldName.messages] - Кастомные сообщения об ошибках.
 *             @param {string} [options.validateFields.fieldName.messages.required] - Сообщение для обязательного поля.
 *             @param {string} [options.validateFields.fieldName.messages.email] - Сообщение для невалидного email.
 *             @param {string} [options.validateFields.fieldName.messages.numeric] - Сообщение для нечислового значения.
 *             @param {string} [options.validateFields.fieldName.messages.minLength] - Сообщение для минимальной длины.
 *             @param {string} [options.validateFields.fieldName.messages.maxLength] - Сообщение для максимальной длины.
 *
 * @param {Object} [options.callbacks] - Callback функции для обработки событий формы.
 *     @param {Function} [options.callbacks.beforeSubmit] - Вызывается перед отправкой формы после успешной валидации.
 *         @param {Object} formData - Данные формы в виде объекта.
 *         @returns {boolean|undefined} - Если возвращает false, отправка формы отменяется.
 *     @param {Function} [options.callbacks.onSubmit] - Вызывается для отправки формы (используется для AJAX запросов).
 *         @param {Object} formData - Данные формы в виде объекта.
 *         @returns {Promise|undefined} - Если возвращает Promise, система будет ждать его разрешения.
 *     @param {Function} [options.callbacks.onSuccess] - Вызывается после успешной отправке формы.
 *         @param {Object} formData - Данные формы в виде объекта.
 *     @param {Function} [options.callbacks.onError] - Вызывается при ошибке валидации или AJAX запроса.
 *         @param {Error|null} error - Объект ошибки, если есть.
 *     @param {Function} [options.callbacks.onReset] - Вызывается при сбросе формы.
 *
 * @param {boolean} [options.liveValidation=true] - Включить валидацию в реальном времени при вводе.
 * @param {boolean} [options.showSuccessMessage=true] - Показывать стандартное сообщение об успехе.
 * @param {number} [options.successMessageDuration=4000] - Длительность показа сообщения об успехе в миллисекундах.
 * @param {string} [options.successMessageText="✅ Form submitted successfully!"] - Текст сообщения об успехе.
 * @param {boolean} [options.debug=false] - Режим отладки с выводом информации в консоль.
 *
 * @returns {Object|null} API объект для управления формой или null, если контейнер не найден.
 *     @returns {Function} validate - Выполняет валидацию формы.
 *     @returns {Function} reset - Сбрасывает форму и очищает ошибки.
 *     @returns {Function} getData - Возвращает данные формы в виде объекта.
 *     @returns {Function} submit - Имитирует клик по кнопке отправки.
 *     @returns {Function} updateConfig - Обновляет конфигурацию формы.
 *
 * @throws {Error} Не выбрасывает исключения, но выводит предупреждения в консоль при ошибках.
 */
export const initFeedbackForm = (containerSelector = ".have-a-questions", options = {}) => {
    // Конфигурация по умолчанию
    const defaultConfig = {
        // Какие поля валидировать
        validateFields: {},
        // Callback функции
        callbacks: {
            // Вызывается при успешной валидации перед отправкой
            beforeSubmit: null,
            // Вызывается при успешной отправке формы
            onSuccess: null,
            // Вызывается при ошибке валидации
            onError: null,
            // Вызывается при отправке формы (можно использовать для AJAX)
            onSubmit: null,
            // Вызывается при сбросе формы
            onReset: null,
        },
        // Простые настройки
        liveValidation: true,
        showSuccessMessage: true,
        successMessageDuration: 4000,
        successMessageText: "✅ Form submitted successfully!",
        debug: false,
    };

    // Объединяем настройки пользователя с настройками по умолчанию
    // Используем spread оператор для поверхностного копирования объектов
    const config = { ...defaultConfig, ...options };
    const feedbackFormContainer = document.querySelector(containerSelector);

    // Проверяем существование контейнера формы
    if (!feedbackFormContainer) {
        console.warn(`Контейнер формы не найден: ${containerSelector}`);
        return null;
    }

    const form = feedbackFormContainer.querySelector("form");
    const sendButton = form ? form.querySelector(".btn-send") : null;

    // Инициализируем кастомные селекторы (выпадающие списки с чекбоксами)
    initCustomSelectors(feedbackFormContainer);

    // Если форма и кнопка отправки существуют, инициализируем обработчики
    if (sendButton && form) {
        initFormSubmission(form, sendButton);
    }

    // === ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ===

    /**
     * Инициализирует все кастомные селекторы в указанном контейнере.
     * Настраивает открытие/закрытие, логику exclusive чекбоксов и валидацию в реальном времени.
     *
     * @param {HTMLElement} container - DOM элемент, содержащий кастомные селекторы.
     */
    function initCustomSelectors(container) {
        const customSelectors = container.querySelectorAll(".custom-select");

        customSelectors.forEach(customSelector => {
            if (customSelector.classList.contains("select-booking-datetime")) return;

            const customSelectorTop = customSelector.querySelector(".custom-select_top");
            const customSelectorList = customSelector.querySelector(".custom-select_list");
            const checkboxes = customSelectorList ? customSelectorList.querySelectorAll('input[type="checkbox"]') : [];
            const onlyOneCheckboxes = customSelectorList ? customSelectorList.querySelectorAll(".onlyOne") : [];

            // Обработчик клика по верхней части селектора для открытия/закрытия списка
            customSelectorTop.addEventListener("click", () => {
                toggleSelectList(customSelectorTop, customSelectorList);
                updateCustomSelectValideState(customSelector);
            });

            // Инициализация логики exclusive чекбоксов (только один может быть выбран)
            initExclusiveCheckboxes(checkboxes, onlyOneCheckboxes);

            // Закрытие селектора при клике вне его области
            document.addEventListener("click", e => {
                if (!customSelector.contains(e.target)) {
                    customSelectorTop.classList.remove("active");
                    customSelectorList.classList.remove("active");
                    updateCustomSelectValideState(customSelector);
                }
            });

            // Валидация в реальном времени для кастомных селекторов
            if (config.liveValidation) {
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener("change", () => {
                        validateCustomSelectField(customSelector);
                        updateCustomSelectValideState(customSelector);
                    });
                });
            }

            updateCustomSelectValideState(customSelector);
        });

        /**
         * Переключает видимость выпадающего списка кастомного селектора.
         *
         * @param {HTMLElement} topElement - Верхняя часть селектора (кнопка открытия).
         * @param {HTMLElement} listElement - Выпадающий список с опциями.
         */
        function toggleSelectList(topElement, listElement) {
            topElement.classList.toggle("active");
            listElement.classList.toggle("active");
        }

        /**
         * Добавляет/убирает класс valide у .custom-select_top,
         * если выбран хотя бы один чекбокс и селектор не активен.
         *
         * @param {HTMLElement} customSelectElement - DOM элемент кастомного селектора.
         */
        function updateCustomSelectValideState(customSelectElement) {
            const customSelectTop = customSelectElement.querySelector(".custom-select_top");
            if (!customSelectTop) return;

            const hasChecked = customSelectElement.querySelectorAll('input[type="checkbox"]:checked').length > 0;
            const isActive = customSelectTop.classList.contains("active");

            if (hasChecked && !isActive) {
                customSelectTop.classList.add("valide");
            } else {
                customSelectTop.classList.remove("valide");
            }
        }

        /**
         * Настраивает логику exclusive чекбоксов в кастомном селекторе.
         * Чекбоксы с классом "onlyOne" могут быть выбраны только по одному.
         *
         * @param {NodeList} checkboxes - Все чекбоксы в селекторе.
         * @param {NodeList} onlyOneCheckboxes - Чекбоксы с классом "onlyOne".
         */
        function initExclusiveCheckboxes(checkboxes, onlyOneCheckboxes) {
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    // Если выбран exclusive чекбокс, снимаем выбор со всех остальных
                    if (this.classList.contains("onlyOne") && this.checked) {
                        uncheckAllExcept(this, checkboxes);
                    }
                    // Если выбран обычный чекбокс, снимаем выбор со всех exclusive
                    else if (!this.classList.contains("onlyOne") && this.checked) {
                        uncheckOnlyOneCheckboxes(onlyOneCheckboxes);
                    }
                });
            });
        }

        /**
         * Снимает выбор со всех чекбоксов, кроме указанного.
         *
         * @param {HTMLInputElement} exceptCheckbox - Чекбокс, который нужно оставить выбранным.
         * @param {NodeList} allCheckboxes - Все чекбоксы в группе.
         */
        function uncheckAllExcept(exceptCheckbox, allCheckboxes) {
            allCheckboxes.forEach(otherCheckbox => {
                if (otherCheckbox !== exceptCheckbox) {
                    otherCheckbox.checked = false;
                }
            });
        }

        /**
         * Снимает выбор со всех exclusive чекбоксов.
         *
         * @param {NodeList} onlyOneCheckboxes - Массив exclusive чекбоксов.
         */
        function uncheckOnlyOneCheckboxes(onlyOneCheckboxes) {
            onlyOneCheckboxes.forEach(onlyOneCheckbox => {
                if (onlyOneCheckbox.checked) {
                    onlyOneCheckbox.checked = false;
                }
            });
        }
    }

    /**
     * Обновляет состояние класса valide у всех кастомных селекторов.
     * Используется после сброса формы, чтобы убрать классы при отсутствии выбранных чекбоксов.
     */
    function refreshCustomSelectValideStates() {
        const customSelectors = feedbackFormContainer.querySelectorAll(".custom-select");
        customSelectors.forEach(customSelectElement => {
            const customSelectTop = customSelectElement.querySelector(".custom-select_top");
            if (!customSelectTop) return;

            const hasChecked = customSelectElement.querySelectorAll('input[type="checkbox"]:checked').length > 0;
            const isActive = customSelectTop.classList.contains("active");

            if (hasChecked && !isActive) {
                customSelectTop.classList.add("valide");
            } else {
                customSelectTop.classList.remove("valide");
            }
        });
    }

    /**
     * Проверяет, находится ли поле внутри кастомного селектора.
     * Используется для определения типа валидации.
     *
     * @param {HTMLElement} field - Проверяемый DOM элемент поля.
     * @returns {boolean} true если поле внутри элемента с классом "custom-select".
     */
    function isCustomSelectField(field) {
        return field.closest(".custom-select") !== null;
    }

    /**
     * Возвращает элемент для отображения ошибки валидации.
     * Для кастомных селекторов ошибка показывается у верхней части (.custom-select_top),
     * для обычных полей - у самого поля.
     *
     * @param {HTMLElement} field - Поле, для которого нужно получить элемент ошибки.
     * @returns {HTMLElement} Элемент для отображения ошибки.
     */
    function getErrorDisplayElement(field) {
        if (isCustomSelectField(field)) {
            return field.closest(".custom-select").querySelector(".custom-select_top");
        }
        return field;
    }

    /**
     * Находит контейнер кастомного селектора для указанного поля.
     *
     * @param {HTMLElement} field - Поле внутри кастомного селектора.
     * @returns {HTMLElement|null} Контейнер .custom-select или null если не найден.
     */
    function getCustomSelectContainer(field) {
        return field.closest(".custom-select");
    }

    /**
     * Находит DOM элемент поля по его селектору из конфигурации.
     *
     * @param {HTMLFormElement} formElement - Форма, в которой искать поле.
     * @param {Object} fieldConfig - Конфигурация поля (должен содержать selector).
     * @returns {HTMLElement|null} Найденный DOM элемент или null.
     */
    function normalizeSelector(selector) {
        if (!selector) return selector;
        const nameSelectorRegex = /\[name=(["'])([^"']+)\1\]/g;
        return selector.replace(nameSelectorRegex, '[data-field="$2"]');
    }

    function queryFieldBySelector(root, selector) {
        if (!selector || !root) return null;
        const directMatch = root.querySelector(selector);
        if (directMatch) return directMatch;
        const normalized = normalizeSelector(selector);
        if (normalized === selector) return null;
        return root.querySelector(normalized);
    }

    function getFieldElement(formElement, fieldConfig) {
        return queryFieldBySelector(formElement, fieldConfig.selector);
    }

    /**
     * Получает значение поля в зависимости от его типа.
     * Для кастомных селекторов возвращает boolean (есть ли выбранные чекбоксы).
     * Для чекбоксов/радио возвращает значение если выбрано, иначе пустую строку.
     * Для select-multiple возвращает массив выбранных значений.
     * Для других полей возвращает строковое значение.
     *
     * @param {HTMLElement} field - DOM элемент поля.
     * @returns {string|boolean|Array} Значение поля в соответствующем формате.
     */
    function getFieldValue(field) {
        // Обработка кастомных селекторов
        if (isCustomSelectField(field)) {
            const container = getCustomSelectContainer(field);
            const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
            return checkboxes.length > 0; // true если есть выбранные чекбоксы
        }

        // Обработка чекбоксов и радио кнопок
        if (field.type === "checkbox" || field.type === "radio") {
            return field.checked ? field.value : "";
        }

        // Обработка множественного выбора в select
        if (field.type === "select-multiple") {
            return Array.from(field.selectedOptions).map(option => option.value);
        }

        // Обработка обычных полей ввода
        return field.value;
    }

    /**
     * Инициализирует обработчик отправки формы.
     * Настраивает валидацию, вызов callback функций и обработку результатов.
     *
     * @param {HTMLFormElement} formElement - DOM элемент формы.
     * @param {HTMLElement} submitButton - Кнопка отправки формы.
     */
    function initFormSubmission(formElement, submitButton) {
        // Основной обработчик клика по кнопке отправки
        submitButton.addEventListener("click", function (e) {
            e.preventDefault(); // Предотвращаем стандартную отправку формы

            // Очищаем предыдущие ошибки валидации
            clearAllErrors(formElement);

            // Выполняем валидацию всех полей
            const isValid = validateForm(formElement);

            if (isValid) {
                // Вызываем callback beforeSubmit если он настроен
                if (config.callbacks.beforeSubmit) {
                    const beforeSubmitResult = config.callbacks.beforeSubmit(getFormData(formElement));
                    // Если beforeSubmit вернул false, отменяем отправку
                    if (beforeSubmitResult === false) {
                        return;
                    }
                }

                // Вызываем callback onSubmit для AJAX отправки
                if (config.callbacks.onSubmit) {
                    const submitResult = config.callbacks.onSubmit(getFormData(formElement));

                    // Если onSubmit вернул Promise, обрабатываем асинхронно
                    if (submitResult && typeof submitResult.then === "function") {
                        submitResult
                            .then(() => handleFormSuccess(formElement))
                            .catch(error => handleFormError(formElement, error));
                    } else {
                        handleFormSuccess(formElement);
                    }
                } else {
                    // Если AJAX отправка не настроена, просто обрабатываем успех
                    handleFormSuccess(formElement);
                }
            } else {
                // Если валидация не пройдена, обрабатываем ошибку
                handleFormError(formElement);
            }
        });

        // Инициализируем валидацию в реальном времени если включена в настройках
        if (config.liveValidation) {
            initLiveValidation(formElement);
        }
    }

    /**
     * Выполняет валидацию всех полей формы согласно конфигурации.
     * Показывает ошибки для невалидных полей и очищает ошибки для валидных.
     *
     * @param {HTMLFormElement} formElement - DOM элемент формы.
     * @returns {boolean} true если все поля валидны, false если есть ошибки.
     */
    function validateForm(formElement) {
        let isValid = true;

        // Проходим по всем сконфигурированным полям
        Object.entries(config.validateFields).forEach(([fieldName, fieldConfig]) => {
            const field = getFieldElement(formElement, fieldConfig);
            if (!field) return; // Пропускаем если поле не найдено

            const value = getFieldValue(field);
            const fieldErrors = validateField(value, field, fieldConfig);

            const errorElement = getErrorDisplayElement(field);

            // Если есть ошибки, показываем первую из них
            if (fieldErrors.length > 0) {
                isValid = false;
                showFieldError(errorElement, fieldErrors[0]);
            } else {
                // Если ошибок нет, очищаем возможные предыдущие ошибки
                clearFieldError(errorElement);
            }
        });

        return isValid;
    }

    /**
     * Валидирует одно поле согласно его конфигурации.
     * Проверяет все заданные правила (required, email, numeric, minLength, maxLength).
     *
     * @param {string|boolean|Array} value - Значение поля.
     * @param {HTMLElement} field - DOM элемент поля.
     * @param {Object} fieldConfig - Конфигурация правил валидации для поля.
     * @returns {Array} Массив строк с сообщениями об ошибках. Пустой если ошибок нет.
     */
    function validateField(value, field, fieldConfig) {
        const errors = [];

        // Проверка обязательности заполнения
        if (fieldConfig.required) {
            let isFieldValid = false;

            // Разная логика валидации для разных типов полей
            if (isCustomSelectField(field)) {
                // Для кастомных селекторов value это boolean
                isFieldValid = value === true;
            } else if (field.type === "checkbox" || field.type === "radio") {
                // Для чекбоксов и радио проверяем состояние checked
                isFieldValid = field.checked;
            } else if (field.name && field.name.includes("[]")) {
                // Для массивов чекбоксов проверяем количество выбранных
                const allCheckboxes = field.form.querySelectorAll(`input[name="${field.name}"]:checked`);
                isFieldValid = allCheckboxes.length > 0;
            } else {
                // Для обычных полей проверяем длину строки
                isFieldValid = String(value).trim().length > 0;
            }

            if (!isFieldValid) {
                errors.push(fieldConfig.messages?.required || "This field is required");
            }
        }

        // Валидация email формата
        if (fieldConfig.email && value && String(value).trim()) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(String(value).trim())) {
                errors.push(fieldConfig.messages?.email || "Please enter a valid email address");
            }
        }

        /**
         * Валидация только цифр.
         * Проверяет, состоит ли значение только из цифр (0-9).
         * Разрешает пустую строку если поле не обязательно.
         *
         * @param {string} value - Значение для проверки.
         * @returns {boolean} true если значение состоит только из цифр или пустое и не обязательно.
         */
        if (fieldConfig.numeric && value && String(value).trim()) {
            // Регулярное выражение для проверки только цифр
            // ^ - начало строки
            // [0-9] - любая цифра от 0 до 9
            // + - один или более раз
            // $ - конец строки
            const numericRegex = /^[0-9]+$/;
            if (!numericRegex.test(String(value).trim())) {
                errors.push(fieldConfig.messages?.numeric || "Please enter numbers only");
            }
        }

        // Проверка минимальной длины
        if (fieldConfig.minLength && value && String(value).trim()) {
            if (String(value).length < fieldConfig.minLength) {
                errors.push(fieldConfig.messages?.minLength || `Minimum ${fieldConfig.minLength} characters`);
            }
        }

        // Проверка максимальной длины
        if (fieldConfig.maxLength && value && String(value).trim()) {
            if (String(value).length > fieldConfig.maxLength) {
                errors.push(fieldConfig.messages?.maxLength || `Maximum ${fieldConfig.maxLength} characters`);
            }
        }

        return errors;
    }

    /**
     * Валидирует кастомный селектор в реальном времени.
     * Вызывается при изменении состояния чекбоксов внутри селектора.
     *
     * @param {HTMLElement} customSelectElement - DOM элемент кастомного селектора.
     */
    function validateCustomSelectField(customSelectElement) {
        const customSelectTop = customSelectElement.querySelector(".custom-select_top");
        if (!customSelectTop) return;

        const firstField = customSelectElement.querySelector("input, select, textarea");
        if (!firstField) return;

        // Находим конфигурацию поля для этого селектора
        const fieldName = Object.keys(config.validateFields).find(name => {
            const fieldConfig = config.validateFields[name];
            const field = queryFieldBySelector(document, fieldConfig.selector);
            return field && getCustomSelectContainer(field) === customSelectElement;
        });

        if (!fieldName) return;

        // Выполняем валидацию и показываем/очищаем ошибку
        const fieldConfig = config.validateFields[fieldName];
        const value = getFieldValue(firstField);
        const fieldErrors = validateField(value, firstField, fieldConfig);

        if (fieldErrors.length > 0) {
            showFieldError(customSelectTop, fieldErrors[0]);
        } else {
            clearFieldError(customSelectTop);
        }
    }

    /**
     * Показывает сообщение об ошибке для указанного поля.
     * Создает элемент с сообщением об ошибке и добавляет его после поля.
     * Также изменяет стиль поля для визуального выделения ошибки.
     *
     * @param {HTMLElement} field - Поле, для которого показывается ошибка.
     * @param {string} message - Текст сообщения об ошибке.
     */
    function showFieldError(field, message) {
        // Сначала очищаем возможные предыдущие ошибки
        clearFieldError(field);

        // Создаем элемент для отображения ошибки
        const errorDiv = document.createElement("div");
        errorDiv.className = "error-message";
        errorDiv.textContent = message;

        // Применяем стили для сообщения об ошибке
        errorDiv.style.cssText = `
            color: #ff5b5b;
            font-size: 12px;
            margin-top: 4px;
            font-style: italic;
        `;

        // Добавляем сообщение об ошибке в DOM
        field.parentNode.appendChild(errorDiv);

        // Визуально выделяем поле с ошибкой (красная рамка)
        field.style.borderColor = "#ff5b5b";
    }

    /**
     * Очищает сообщение об ошибке для указанного поля.
     * Удаляет элемент с сообщением об ошибке и восстанавливает стандартный стиль поля.
     *
     * @param {HTMLElement} field - Поле, для которого нужно очистить ошибку.
     */
    function clearFieldError(field) {
        const parent = field.parentNode;
        const existingError = parent.querySelector(".error-message");

        // Удаляем существующее сообщение об ошибке
        if (existingError) {
            existingError.remove();
        }

        // Восстанавливаем стандартный цвет рамки
        field.style.borderColor = "";
    }

    /**
     * Очищает все сообщения об ошибках в форме.
     * Удаляет все элементы .error-message и восстанавливает стили всех полей.
     *
     * @param {HTMLFormElement} formElement - Форма, в которой нужно очистить ошибки.
     */
    function clearAllErrors(formElement) {
        // Удаляем все элементы с сообщениями об ошибках
        const errorMessages = formElement.querySelectorAll(".error-message");
        errorMessages.forEach(error => error.remove());

        // Восстанавливаем стандартные стили всех полей ввода
        const fields = formElement.querySelectorAll("input, textarea, select, .custom-select_top");
        fields.forEach(field => {
            field.style.borderColor = "";
        });
    }

    /**
     * Инициализирует валидацию в реальном времени для всех полей формы.
     * Добавляет обработчики событий input/change для немедленной валидации при вводе.
     * Для полей с numeric валидацией также добавляет фильтрацию ввода.
     *
     * @param {HTMLFormElement} formElement - Форма, для которой настраивается валидация.
     */
    function initLiveValidation(formElement) {
        Object.entries(config.validateFields).forEach(([fieldName, fieldConfig]) => {
            const field = getFieldElement(formElement, fieldConfig);
            if (!field) return;

            // Пропускаем кастомные селекторы (они уже обрабатываются отдельно)
            if (isCustomSelectField(field)) return;

            // Для полей с numeric валидацией добавляем фильтрацию ввода
            if (fieldConfig.numeric && (field.type === "text" || field.type === "tel" || field.type === "number")) {
                addNumericInputFilter(field, fieldConfig);
            }

            // Определяем тип события в зависимости от типа поля
            const eventType =
                field.type === "checkbox" || field.type === "radio"
                    ? "change" // Для чекбоксов и радио валидируем при изменении состояния
                    : "input"; // Для текстовых полей валидируем при вводе

            // Добавляем обработчик валидации в реальном времени
            field.addEventListener(eventType, () => {
                const value = getFieldValue(field);
                const fieldErrors = validateField(value, field, fieldConfig);
                const errorElement = getErrorDisplayElement(field);

                // Показываем или очищаем ошибку в зависимости от результата валидации
                if (fieldErrors.length > 0) {
                    showFieldError(errorElement, fieldErrors[0]);
                } else {
                    clearFieldError(errorElement);
                }
            });
        });

        /**
         * Добавляет фильтр ввода для полей, которые должны содержать только цифры.
         * Предотвращает ввод нецифровых символов.
         *
         * @param {HTMLInputElement} field - Поле ввода для добавления фильтра.
         * @param {Object} fieldConfig - Конфигурация поля.
         */
        function addNumericInputFilter(field, fieldConfig) {
            field.addEventListener("keydown", function (e) {
                // Разрешаем стандартные управляющие клавиши
                if (
                    e.key === "Backspace" ||
                    e.key === "Delete" ||
                    e.key === "Tab" ||
                    e.key === "Escape" ||
                    e.key === "Enter" ||
                    e.key === "Home" ||
                    e.key === "End" ||
                    e.key === "ArrowLeft" ||
                    e.key === "ArrowRight" ||
                    e.key === "ArrowUp" ||
                    e.key === "ArrowDown" ||
                    e.ctrlKey || // Разрешаем Ctrl+C, Ctrl+V, Ctrl+X и т.д.
                    e.metaKey // Разрешаем Cmd+C, Cmd+V и т.д. для Mac
                ) {
                    return;
                }

                // Проверяем, является ли введенный символ цифрой
                if (!/^[0-9]$/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Также проверяем при вставке (paste event)
            field.addEventListener("paste", function (e) {
                // Получаем вставляемый текст
                const pastedText = e.clipboardData.getData("text");

                // Проверяем, содержит ли вставляемый текст только цифры
                if (!/^[0-9]+$/.test(pastedText)) {
                    e.preventDefault();
                    // Показываем сообщение об ошибке
                    showFieldError(field, fieldConfig.messages?.numeric || "Only numbers are allowed");
                }
            });

            // Очищаем ошибку при вводе
            field.addEventListener("input", function () {
                clearFieldError(field);
            });
        }
    }

    /**
     * Собирает данные формы в структурированный объект.
     * Обрабатывает массивы значений (например, множественные чекбоксы).
     *
     * @param {HTMLFormElement} formElement - Форма, данные которой нужно собрать.
     * @returns {Object} Объект с данными формы, где ключи - имена полей.
     */
    function getFormData(formElement) {
        const result = {};
        const elements = Array.from(formElement.elements || []);

        const pushValue = (key, value) => {
            if (result[key] === undefined) {
                result[key] = value;
            } else if (Array.isArray(result[key])) {
                result[key].push(value);
            } else {
                result[key] = [result[key], value];
            }
        };

        elements.forEach(element => {
            if (!element || element.disabled) return;

            const originalName = element.dataset.originalName || element.dataset.field || element.getAttribute("name");
            if (!originalName) return;

            const tagName = element.tagName;
            const type = (element.getAttribute("type") || "").toLowerCase();

            if (["submit", "button", "image", "reset"].includes(type)) return;

            if (type === "checkbox") {
                if (element.checked) {
                    pushValue(originalName, element.value);
                }
                return;
            }

            if (type === "radio") {
                if (element.checked) {
                    pushValue(originalName, element.value);
                }
                return;
            }

            if (tagName === "SELECT" && element.multiple) {
                Array.from(element.selectedOptions).forEach(option => {
                    pushValue(originalName, option.value);
                });
                return;
            }

            if (type === "file") {
                const files = element.files ? Array.from(element.files) : [];
                files.forEach(file => {
                    pushValue(originalName, file);
                });
                return;
            }

            pushValue(originalName, element.value);
        });

        return result;
    }

    /**
     * Обрабатывает успешную отправку формы.
     * Вызывает callback onSuccess, показывает сообщение об успехе и сбрасывает форму.
     *
     * @param {HTMLFormElement} formElement - Отправленная форма.
     */
    function handleFormSuccess(formElement) {
        // Логирование в режиме отладки
        if (config.debug) {
            console.log("✅ Форма успешно отправлена!", getFormData(formElement));
        }

        // Вызываем пользовательский callback onSuccess если он настроен
        if (config.callbacks.onSuccess) {
            config.callbacks.onSuccess(getFormData(formElement));
        }

        // Показываем стандартное сообщение об успехе если включено в настройках
        if (config.showSuccessMessage) {
            showSuccessMessage(formElement);
        }

        // Автоматически сбрасываем форму после успешной отправки
        formElement.reset();
        refreshCustomSelectValideStates();
    }

    /**
     * Обрабатывает ошибку отправки формы.
     * Вызывает callback onError и логирует ошибку в режиме отладки.
     *
     * @param {HTMLFormElement} formElement - Форма с ошибкой.
     * @param {Error|null} [error=null] - Объект ошибки, если есть (например, от AJAX запроса).
     */
    function handleFormError(formElement, error = null) {
        // Логирование в режиме отладки
        if (config.debug) {
            console.warn("❌ Ошибка отправки формы:", error);
        }

        // Вызываем пользовательский callback onError если он настроен
        if (config.callbacks.onError) {
            config.callbacks.onError(error);
        }
    }

    /**
     * Показывает временное сообщение об успешной отправке формы.
     * Создает и добавляет в DOM элемент с сообщением, который автоматически удаляется через заданное время.
     *
     * @param {HTMLFormElement} formElement - Форма, после которой показывать сообщение.
     */
    function showSuccessMessage(formElement) {
        // Удаляем предыдущее сообщение если оно существует
        const existingMessage = formElement.querySelector(".success-message");
        if (existingMessage) existingMessage.remove();

        // Создаем элемент сообщения
        const successMessage = document.createElement("div");
        successMessage.className = "success-message";
        successMessage.textContent = config.successMessageText;

        // Применяем стили для сообщения
        successMessage.style.cssText = `
            color: #00aa00;
            margin-top: 15px;
            padding: 12px;
            background-color: rgba(0, 170, 0, 0.1);
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
            width: 100%;
        `;

        // Добавляем сообщение в DOM после контейнера с кнопкой или в конец формы
        const sendButtonContainer = formElement.querySelector(".btn-and-social");
        if (sendButtonContainer) {
            sendButtonContainer.after(successMessage);
        } else {
            formElement.appendChild(successMessage);
        }

        // Автоматически удаляем сообщение через заданное время
        setTimeout(() => successMessage.remove(), config.successMessageDuration);
    }

    // Возвращаем API объект для внешнего управления формой
    return {
        /**
         * Выполняет валидацию всех полей формы согласно текущей конфигурации.
         * @returns {boolean} true если все поля валидны, false если есть ошибки.
         */
        validate: () => validateForm(form),

        /**
         * Сбрасывает форму: очищает значения полей, ошибки валидации и вызывает callback onReset.
         */
        reset: () => {
            if (form) {
                form.reset();
                clearAllErrors(form);
                refreshCustomSelectValideStates();
                // Вызываем callback onReset если он настроен
                if (config.callbacks.onReset) {
                    config.callbacks.onReset();
                }
            }
        },

        /**
         * Собирает текущие данные формы в объект.
         * @returns {Object|null} Данные формы или null если форма не найдена.
         */
        getData: () => (form ? getFormData(form) : null),

        /**
         * Программно инициирует отправку формы (имитирует клик по кнопке отправки).
         */
        submit: () => {
            if (form && sendButton) {
                sendButton.click();
            }
        },

        /**
         * Обновляет конфигурацию формы во время выполнения.
         * @param {Object} newConfig - Новая конфигурация (частично или полностью).
         */
        updateConfig: newConfig => {
            Object.assign(config, newConfig);
        },
    };
};
