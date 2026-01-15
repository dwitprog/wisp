import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";

const form = initFeedbackForm(".have-a-questions", {
    validateFields: {
        name: { required: true, selector: 'input[name="name"]' },
        email: { required: true, email: true, selector: 'input[name="email"]' },
        "web-site": { required: true, selector: 'input[name="web-site"]' },
        interest: {
            required: true,
            selector: ".select-interest",
            customSelect: true,
            messages: {
                required: "Please select at least one service",
            },
        },
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
