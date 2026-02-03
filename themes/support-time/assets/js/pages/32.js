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

const haveAQuestionsForm = document.querySelector(".page-32.have-a-questions");
if (haveAQuestionsForm) {
    const formContent = haveAQuestionsForm.querySelector(".page-32.have-a-questions .content");
    const afterSendContent = haveAQuestionsForm.querySelector(".page-32.have-a-questions  .after-send");
    const btnSubmit = haveAQuestionsForm.querySelector(".page-32.have-a-questions .btn-send");

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
        showSuccessMessage: false,
        callbacks: {
            beforeSubmit: () => {
                if (btnSubmit) btnSubmit.setAttribute("disabled", "disabled");
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

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 20000);

                return fetch(ajaxUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    body: payload.toString(),
                    signal: controller.signal,
                })
                    .then(response => {
                        clearTimeout(timeoutId);
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
                    })
                    .catch(err => {
                        clearTimeout(timeoutId);
                        throw err;
                    });
            },
            onSuccess: () => {
                if (btnSubmit) btnSubmit.removeAttribute("disabled");
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
            onError: () => {
                if (btnSubmit) btnSubmit.removeAttribute("disabled");
            },
        },
    });
}
initFAQAccordion(".faq-accordion");

// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-32.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});
