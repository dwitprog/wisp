import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";

const form = initFeedbackForm(".have-a-questions", {
    validateFields: {
        name: { required: true, selector: 'input[name="name"]' },
        email: { required: true, email: true, selector: 'input[name="email"]' },
        scope: { required: true, selector: 'input[name="scope"]' },
        duration: { required: true, selector: 'input[name="duration"]' },
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

// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-40.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});
