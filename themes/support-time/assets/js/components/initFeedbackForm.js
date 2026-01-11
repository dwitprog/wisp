/**
 * Инициализация формы обратной связи с валидацией и кастомными селекторами
 * @param {string} containerSelector - Селектор контейнера формы
 */
export const initFeedbackForm = (containerSelector = ".have-a-questions") => {
    const feedbackFormContainer = document.querySelector(containerSelector);

    // Выходим если контейнер не найден
    if (!feedbackFormContainer) {
        console.warn(`Контейнер формы не найден: ${containerSelector}`);
        return;
    }

    const form = feedbackFormContainer.querySelector("form");
    const sendButton = form ? form.querySelector(".btn-send") : null;

    // Инициализируем кастомные селекторы
    initCustomSelectors(feedbackFormContainer);

    // Если есть форма и кнопка отправки - инициализируем обработчик
    if (sendButton && form) {
        initFormSubmission(form, sendButton);
    }

    // === ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ ===

    /**
     * Инициализирует все кастомные селекторы в контейнере
     * @param {HTMLElement} container - Контейнер с формами
     */
    function initCustomSelectors(container) {
        const customSelectors = container.querySelectorAll(".custom-select");

        customSelectors.forEach(customSelector => {
            const customSelectorTop = customSelector.querySelector(".custom-select_top");
            const customSelectorList = customSelector.querySelector(".custom-select_list");
            const checkboxes = customSelectorList.querySelectorAll('input[type="checkbox"]');
            const onlyOneCheckboxes = customSelectorList.querySelectorAll(".onlyOne");

            // 1. Обработчик открытия/закрытия списка
            customSelectorTop.addEventListener("click", () => {
                toggleSelectList(customSelectorTop, customSelectorList);
            });

            // 2. Логика для чекбоксов с exclusive выбором
            initExclusiveCheckboxes(checkboxes, onlyOneCheckboxes);

            // 3. Закрытие при клике вне селектора
            initCloseOnClickOutside(customSelector, customSelectorTop, customSelectorList);
        });
    }

    /**
     * Переключает состояние выпадающего списка
     * @param {HTMLElement} topElement - Верхняя часть селектора
     * @param {HTMLElement} listElement - Список опций
     */
    function toggleSelectList(topElement, listElement) {
        topElement.classList.toggle("active");
        listElement.classList.toggle("active");
    }

    /**
     * Инициализирует логику exclusive чекбоксов
     * @param {NodeList} checkboxes - Все чекбоксы в селекторе
     * @param {NodeList} onlyOneCheckboxes - Чекбоксы с классом .onlyOne
     */
    function initExclusiveCheckboxes(checkboxes, onlyOneCheckboxes) {
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                handleCheckboxChange(this, checkboxes, onlyOneCheckboxes);
            });
        });
    }

    /**
     * Обрабатывает изменение состояния чекбокса
     * @param {HTMLInputElement} changedCheckbox - Измененный чекбокс
     * @param {NodeList} allCheckboxes - Все чекбоксы в группе
     * @param {NodeList} onlyOneCheckboxes - Exclusive чекбоксы
     */
    function handleCheckboxChange(changedCheckbox, allCheckboxes, onlyOneCheckboxes) {
        // Если выбран exclusive чекбокс
        if (changedCheckbox.classList.contains("onlyOne") && changedCheckbox.checked) {
            uncheckAllExcept(changedCheckbox, allCheckboxes);
        }
        // Если выбран обычный чекбокс
        else if (!changedCheckbox.classList.contains("onlyOne") && changedCheckbox.checked) {
            uncheckOnlyOneCheckboxes(onlyOneCheckboxes);
        }
    }

    /**
     * Снимает выбор со всех чекбоксов кроме указанного
     * @param {HTMLInputElement} exceptCheckbox - Чекбокс который нужно оставить
     * @param {NodeList} allCheckboxes - Все чекбоксы в группе
     */
    function uncheckAllExcept(exceptCheckbox, allCheckboxes) {
        allCheckboxes.forEach(otherCheckbox => {
            if (otherCheckbox !== exceptCheckbox) {
                otherCheckbox.checked = false;
            }
        });
    }

    /**
     * Снимает выбор со всех exclusive чекбоксов
     * @param {NodeList} onlyOneCheckboxes - Exclusive чекбоксы
     */
    function uncheckOnlyOneCheckboxes(onlyOneCheckboxes) {
        onlyOneCheckboxes.forEach(onlyOneCheckbox => {
            if (onlyOneCheckbox.checked) {
                onlyOneCheckbox.checked = false;
            }
        });
    }

    /**
     * Закрывает селектор при клике вне его области
     * @param {HTMLElement} customSelector - Контейнер селектора
     * @param {HTMLElement} customSelectorTop - Верхняя часть селектора
     * @param {HTMLElement} customSelectorList - Выпадающий список
     */
    function initCloseOnClickOutside(customSelector, customSelectorTop, customSelectorList) {
        document.addEventListener("click", e => {
            if (!customSelector.contains(e.target)) {
                customSelectorTop.classList.remove("active");
                customSelectorList.classList.remove("active");
            }
        });
    }

    /**
     * Инициализирует обработчик отправки формы
     * @param {HTMLFormElement} formElement - Элемент формы
     * @param {HTMLButtonElement} submitButton - Кнопка отправки
     */
    function initFormSubmission(formElement, submitButton) {
        submitButton.addEventListener("click", function (e) {
            e.preventDefault();

            // Сбрасываем предыдущие ошибки
            resetAllErrors(formElement);

            // Выполняем валидацию
            const validationResult = validateForm(formElement);

            // Если форма валидна - обрабатываем данные
            if (validationResult.isValid) {
                processFormData(formElement);
            } else {
                console.warn("❌ Ошибки валидации формы:", validationResult.errors);
            }
        });

        // Инициализируем валидацию в реальном времени
        initLiveValidation(formElement);
    }

    /**
     * Валидирует форму
     * @param {HTMLFormElement} formElement - Элемент формы
     * @returns {Object} Результат валидации {isValid: boolean, errors: Array}
     */
    function validateForm(formElement) {
        const errors = [];
        let isValid = true;

        // Валидация имени
        const nameInput = formElement.querySelector('input[name="name"]');
        if (!validateRequiredField(nameInput, "Имя")) {
            showFieldError(nameInput, "Please enter your name");
            errors.push("Name is required");
            isValid = false;
        }

        // Валидация email
        const emailInput = formElement.querySelector('input[name="email"]');
        const emailValidation = validateEmailField(emailInput);
        if (!emailValidation.isValid) {
            showFieldError(emailInput, emailValidation.message);
            errors.push(emailValidation.message);
            isValid = false;
        }

        // Валидация кастомных селекторов
        const customSelects = formElement.querySelectorAll(".custom-select");
        customSelects.forEach(customSelect => {
            if (!validateCustomSelect(customSelect)) {
                const customSelectTop = customSelect.querySelector(".custom-select_top");
                showFieldError(customSelectTop, "Please select at least one option");
                errors.push("Custom select is required");
                isValid = false;
            }
        });

        return { isValid, errors };
    }

    /**
     * Валидирует обязательное поле
     * @param {HTMLInputElement} field - Поле для валидации
     * @param {string} fieldName - Название поля для сообщения об ошибке
     * @returns {boolean} Результат валидации
     */
    function validateRequiredField(field, fieldName) {
        return field && field.value.trim().length > 0;
    }

    /**
     * Валидирует поле email
     * @param {HTMLInputElement} emailField - Поле с email
     * @returns {Object} Результат валидации {isValid: boolean, message: string}
     */
    function validateEmailField(emailField) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const emailValue = emailField ? emailField.value.trim() : "";

        if (!emailValue) {
            return { isValid: false, message: "Please enter your email" };
        }

        if (!emailRegex.test(emailValue)) {
            return { isValid: false, message: "Please enter a valid email address." };
        }

        return { isValid: true, message: "" };
    }

    /**
     * Валидирует кастомный селектор
     * @param {HTMLElement} customSelect - Элемент кастомного селектора
     * @returns {boolean} Результат валидации
     */
    function validateCustomSelect(customSelect) {
        const checkboxes = customSelect.querySelectorAll('input[type="checkbox"]');
        return Array.from(checkboxes).some(cb => cb.checked);
    }

    /**
     * Показывает ошибку для поля
     * @param {HTMLElement} field - Поле с ошибкой
     * @param {string} message - Сообщение об ошибке
     */
    function showFieldError(field, message) {
        // Создаем контейнер для ошибки
        let errorContainer = field.parentElement.querySelector(".error-message");

        if (!errorContainer) {
            errorContainer = document.createElement("div");
            errorContainer.className = "error-message";
            field.parentElement.appendChild(errorContainer);
        }

        // Устанавливаем сообщение и стили
        errorContainer.textContent = message;

        // Добавляем стиль ошибки к полю
        field.style.borderColor = "#ff0000";

        // Для кастомных селекторов добавляем отдельный класс
        if (field.classList.contains("custom-select_top")) {
            field.classList.add("error");
        }
    }

    /**
     * Сбрасывает все ошибки в форме
     * @param {HTMLFormElement} formElement - Элемент формы
     */
    function resetAllErrors(formElement) {
        const errorElements = formElement.querySelectorAll(".error-message");
        errorElements.forEach(error => error.remove());

        const fieldsWithError = formElement.querySelectorAll('[style*="border-color"]');
        fieldsWithError.forEach(field => {
            field.style.borderColor = "";
            field.classList.remove("error");
        });
    }

    /**
     * Инициализирует валидацию в реальном времени
     * @param {HTMLFormElement} formElement - Элемент формы
     */
    function initLiveValidation(formElement) {
        const validatedFields = formElement.querySelectorAll('input[name="name"], input[name="email"]');

        validatedFields.forEach(field => {
            field.addEventListener("input", () => resetFieldError(field));
        });
    }

    /**
     * Сбрасывает ошибку конкретного поля
     * @param {HTMLInputElement} field - Поле для сброса ошибки
     */
    function resetFieldError(field) {
        field.style.borderColor = "";
        field.classList.remove("error");

        const errorContainer = field.parentElement.querySelector(".error-message");
        if (errorContainer) {
            errorContainer.remove();
        }
    }

    /**
     * Обрабатывает данные формы после успешной валидации
     * @param {HTMLFormElement} formElement - Элемент формы
     */
    function processFormData(formElement) {
        // Собираем данные формы
        const formData = collectFormData(formElement);

        // Выводим в консоль (замените на реальную отправку)
        console.log("✅ Данные формы успешно валидированы!");
        console.log("📋 Отправляемые данные:", formData);

        // Показываем сообщение об успехе
        showSuccessMessage(formElement);
    }

    /**
     * Собирает данные формы в структурированный объект
     * @param {HTMLFormElement} formElement - Элемент формы
     * @returns {Object} Структурированные данные формы
     */
    function collectFormData(formElement) {
        const formData = new FormData(formElement);
        const result = {};

        formData.forEach((value, key) => {
            // Обработка массивов (чекбоксы с одинаковыми именами)
            if (result[key]) {
                if (Array.isArray(result[key])) {
                    result[key].push(value);
                } else {
                    result[key] = [result[key], value];
                }
            } else {
                result[key] = value;
            }
        });

        return result;
    }

    /**
     * Показывает временное сообщение об успешной отправке
     * @param {HTMLFormElement} formElement - Элемент формы
     */
    function showSuccessMessage(formElement) {
        // Удаляем предыдущее сообщение если есть
        const existingMessage = formElement.querySelector(".success-message");
        if (existingMessage) existingMessage.remove();

        // Создаем новое сообщение
        const successMessage = document.createElement("div");
        successMessage.className = "success-message";
        successMessage.textContent = "✅ Форма успешно отправлена! Данные в консоли.";

        // Стилизация сообщения
        Object.assign(successMessage.style, {
            color: "#00aa00",
            marginTop: "15px",
            padding: "12px",
            backgroundColor: "rgba(0, 170, 0, 0.1)",
            borderRadius: "6px",
            textAlign: "center",
            fontSize: "14px",
            fontWeight: "500",
        });

        // Добавляем сообщение после кнопки отправки
        const sendButtonContainer = formElement.querySelector(".btn-and-social");
        if (sendButtonContainer) {
            sendButtonContainer.after(successMessage);
        } else {
            formElement.appendChild(successMessage);
        }

        // Автоматически скрываем через 4 секунды
        setTimeout(() => successMessage.remove(), 4000);
    }
};
