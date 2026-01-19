import { soundWaveVisualizer } from "../components/soundWaveVisualizer";
import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";
import { audioController } from "../components/audioController";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";

const visualizer = soundWaveVisualizer({
    svgId: "soundWave",
    playBtnSelector: ".controls-btn.play",
    animation: {
        minMultiplier: 0.7,
        maxMultiplier: 1.6,
        speed: 0.2,
        fps: 120,
    },
});
const controller = audioController(visualizer);

visualizer.on("play", controller.play);
visualizer.on("pause", controller.pause);
visualizer.on("next", controller.next);
visualizer.on("prev", controller.prev);

const form = initFeedbackForm(".have-a-questions", {
    validateFields: {
        name: { required: true, selector: 'input[name="name"]' },
        email: { required: true, email: true, selector: 'input[name="email"]' },
        scope: { required: true, selector: 'input[name="scope"]' },
        "execution-speed": { required: true, selector: 'input[name="execution-speed"]' },
    },
    callbacks: {
        onSubmit: formData => {
            console.log("📤 Отправляем данные формы:", formData);

            return new Promise(resolve => {
                setTimeout(() => {
                    console.log("✅ Данные успешно отправлены на сервер!");
                    console.log("📊 Статистика отправки:", {
                        timestamp: new Date().toISOString(),
                        fieldsCount: Object.keys(formData).length,
                    });
                    resolve();
                }, 1000);
            });
        },
    },
});
initFAQAccordion(".faq-accordion");
const dateInput = document.getElementById("dateInput");
if (dateInput) {
    // Устанавливаем минимальную дату (опционально)
    const today = new Date();
    const todayFormatted = today.toISOString().split("T")[0];
    dateInput.min = todayFormatted;

    // Получаем элемент плейсхолдера
    const placeholder = dateInput.nextElementSibling;

    // Инициализируем состояние
    updatePlaceholder();

    // Обработчик изменения даты
    dateInput.addEventListener("input", updatePlaceholder);
    dateInput.addEventListener("change", updatePlaceholder);

    function updatePlaceholder() {
        if (dateInput.value) {
            dateInput.classList.add("has-value");
            // Форматируем дату из YYYY-MM-DD в YYYY/MM/DD
            const [year, month, day] = dateInput.value.split("-");
            placeholder.textContent = `${year}/${month}/${day}`;
        } else {
            dateInput.classList.remove("has-value");
            placeholder.textContent = "2026/01/01";
        }
    }

    // Обработчик клика по всему полю
    dateInput.addEventListener("click", function (e) {
        e.preventDefault();

        // Для современных браузеров
        if (typeof this.showPicker === "function") {
            try {
                this.showPicker();
            } catch (err) {
                // Fallback
                this.focus();
            }
        } else {
            // Для старых браузеров
            this.focus();

            // Для Firefox и Safari
            const event = new MouseEvent("mousedown", {
                view: window,
                bubbles: true,
                cancelable: true,
            });
            this.dispatchEvent(event);
        }
    });

    // Также делаем кликабельным весь контейнер
    const container = dateInput.parentElement;
    if (container && container.classList.contains("date-input-container")) {
        container.addEventListener("click", function (e) {
            if (e.target !== dateInput) {
                dateInput.click();
            }
        });
    }
}

// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-36.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});
