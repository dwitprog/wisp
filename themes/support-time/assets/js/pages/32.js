import { soundWaveVisualizer } from "../components/soundWaveVisualizer";
import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";
import { audioController } from "../components/audioController";

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
        budget: { required: true, numeric: true, selector: 'input[name="budget"]' },
        duration: {
            required: true,
            selector: ".select-duration",
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
