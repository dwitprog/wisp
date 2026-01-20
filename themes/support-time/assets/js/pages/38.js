import { initFeedbackForm } from "../components/initFeedbackForm";
import { initFAQAccordion } from "../components/initFAQAccordion";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";
import { gsap } from "gsap";

const haveAQuestionsForm = document.querySelector(".page-38.have-a-questions");
if (haveAQuestionsForm) {
    const formContent = haveAQuestionsForm.querySelector(".page-38.have-a-questions .content");
    const afterSendContent = haveAQuestionsForm.querySelector(".page-38.have-a-questions  .after-send");
    const btnSubmit = haveAQuestionsForm.querySelector(".page-38.have-a-questions .btn-send");
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
// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-38.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});
