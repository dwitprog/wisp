import { soundWaveVisualizer } from "../components/soundWaveVisualizer";
import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";
import { audioController } from "../components/audioController";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";
import { gsap } from "gsap";

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

const haveAQuestionsForm = document.querySelector(".page-36.have-a-questions");
if (haveAQuestionsForm) {
    const formContent = haveAQuestionsForm.querySelector(".page-36.have-a-questions .content");
    const afterSendContent = haveAQuestionsForm.querySelector(".page-36.have-a-questions  .after-send");
    const btnSubmit = haveAQuestionsForm.querySelector(".page-36.have-a-questions .btn-send");

    const form = initFeedbackForm(".have-a-questions", {
        validateFields: {
            name: { required: true, selector: 'input[name="name"]' },
            email: { required: true, email: true, selector: 'input[name="email"]' },
            scope: { required: true, selector: 'input[name="scope"]' },
            "execution-speed": { required: true, selector: 'input[name="execution-speed"]' },
        },
        showSuccessMessage: false,
        callbacks: {
            beforeSubmit: () => {
                btnSubmit.setAttribute("disabled", "disabled");
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

                return fetch(ajaxUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    body: payload.toString(),
                })
                    .then(response => {
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
                    });
            },
            onSuccess: () => {
                btnSubmit.removeAttribute("disabled", "disabled");
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
            },
        },
    });
}
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
