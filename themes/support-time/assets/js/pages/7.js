import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { initFeedbackForm } from "../components/initFeedbackForm";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";

gsap.registerPlugin(ScrollTrigger);

// swiper в секции platforms
const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const swiper = new Swiper(".swiper-content", {
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        speed: 1000,
        grabCursor: true,
        modules: [Navigation],
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
        },
    });
}

// Анимация координат на первом экране
const coordinateContainer = document.querySelector(".coordinates");

if (coordinateContainer) {
    const lineTop = coordinateContainer.querySelector(".line-top .line");
    const lineRight = coordinateContainer.querySelector(".line-right .line");

    // Функция для анимации линий
    function animateLines() {
        // Анимация верхней линии (высота)
        if (lineTop) {
            lineTop.style.display = "block";
            lineTop.style.height = "0";
            lineTop.style.transition = "none";
            setTimeout(() => {
                lineTop.style.transition = "height 1s ease-in-out";
                lineTop.style.height = "100%";
            }, 10);
        }

        // Анимация правой линии (ширина)
        if (lineRight) {
            lineRight.style.display = "block";
            lineRight.style.width = "0";
            lineRight.style.transition = "none";
            setTimeout(() => {
                lineRight.style.transition = "width 1s ease-in-out";
                lineRight.style.width = "100%";
            }, 10);
        }
    }

    // Запускаем анимацию при загрузке
    setTimeout(animateLines, 300);
}

// Анимация секции services (pin + шаги)
const servicesSection = document.querySelector(".page-7.services");
if (servicesSection) {
    const knob = servicesSection.querySelector(".service-knob .knob");
    const items = Array.from(servicesSection.querySelectorAll(".list .item"));
    const totalSteps = 5;
    const stepScrollPercent = 80;
    const stepClasses = Array.from({ length: totalSteps }, (_, idx) => `step_${idx + 1}`);

    const setStep = stepNumber => {
        if (knob) {
            knob.classList.remove(...stepClasses);
            knob.classList.add(`step_${stepNumber}`);
        }

        if (items.length) {
            const targetIndex = Math.min(stepNumber - 1, items.length - 1);
            items.forEach((item, index) => {
                item.classList.toggle("active", index === targetIndex);
            });
        }
    };

    setStep(1);

    ScrollTrigger.create({
        trigger: servicesSection,
        start: "top top",
        end: `+=${(totalSteps - 1) * stepScrollPercent}%`,
        pin: true,
        pinSpacing: true,
        scrub: true,
        anticipatePin: 1,
        onUpdate: self => {
            const stepNumber = Math.min(totalSteps, Math.max(1, Math.floor(self.progress * totalSteps) + 1));
            setStep(stepNumber);
        },
    });
}

// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-7.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});

// Анимация секции faq (pin + движение фейдера)
const faqSection = document.querySelector(".page-7.faq");
if (faqSection) {
    const faqContent = faqSection.querySelector(".faq-content");
    const slider = faqSection.querySelector(".slider");
    const sliderFader = faqSection.querySelector(".slider-fader");
    const items = Array.from(faqSection.querySelectorAll(".items .item"));

    if (faqContent && slider && sliderFader && items.length) {
        let sliderHeight = 0;
        let faderHeight = 0;
        let maxTravel = 0;
        let sliderOffset = 0;
        let itemThresholds = [];
        let contentPaddingTop = 0;
        const scrollLengthMultiplier = 6;
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        let isClickScrolling = false;
        let forcedIndex = null;
        let clickTween = null;

        const measure = () => {
            const sectionTop = faqSection.getBoundingClientRect().top + window.scrollY;

            contentPaddingTop = parseFloat(getComputedStyle(faqContent).paddingTop) || 0;
            sliderHeight = slider.offsetHeight;
            faderHeight = sliderFader.offsetHeight;
            maxTravel = Math.max(0, sliderHeight - faderHeight);
            sliderOffset = slider.getBoundingClientRect().top + window.scrollY - sectionTop;
            const steps = Math.max(1, items.length - 1);
            const stepSize = maxTravel / steps;
            itemThresholds = items.map((_, index) => sliderOffset + stepSize * index);
        };

        measure();
        gsap.set(sliderFader, { y: 0 });

        const faqTrigger = ScrollTrigger.create({
            trigger: faqContent,
            start: () => `top+=50 top`,
            end: () => `+=${Math.max(1, maxTravel) * scrollLengthMultiplier}`,
            pin: true,
            pinSpacing: true,
            scrub: true,
            onRefresh: measure,
            onUpdate: self => {
                const travel = Math.min(maxTravel, Math.max(0, self.progress * maxTravel));
                gsap.set(sliderFader, { y: travel });
                const faderTop = sliderOffset + travel;
                let activeIndex = 0;

                if (isClickScrolling && forcedIndex !== null) {
                    activeIndex = forcedIndex;
                } else {
                    for (let i = 0; i < itemThresholds.length; i += 1) {
                        if (faderTop >= itemThresholds[i]) {
                            activeIndex = i;
                        }
                    }
                }

                items.forEach((item, index) => {
                    item.classList.toggle("active", index === activeIndex);
                });
            },
        });

        items.forEach((item, index) => {
            item.addEventListener("click", event => {
                event.preventDefault();
                if (!faqTrigger) {
                    return;
                }
                measure();
                if (maxTravel === 0) {
                    return;
                }
                const steps = Math.max(1, items.length - 1);
                const stepSize = maxTravel / steps;
                const targetTravel = Math.min(maxTravel, (index + 0.5) * stepSize);
                const targetProgress = clamp(targetTravel / maxTravel, 0, 1);
                const startScroll = faqTrigger.start;
                const endScroll = faqTrigger.end;
                const targetScroll = startScroll + (endScroll - startScroll) * targetProgress;
                const tweenState = { value: faqTrigger.scroll() };

                if (clickTween) {
                    clickTween.kill();
                }
                isClickScrolling = true;
                forcedIndex = index;
                clickTween = gsap.to(tweenState, {
                    value: targetScroll,
                    duration: 0.6,
                    ease: "power1.out",
                    onUpdate: () => {
                        faqTrigger.scroll(tweenState.value);
                    },
                    onComplete: () => {
                        isClickScrolling = false;
                        forcedIndex = null;
                        clickTween = null;
                    },
                    onInterrupt: () => {
                        isClickScrolling = false;
                        forcedIndex = null;
                        clickTween = null;
                    },
                });
            });
        });
    }
}

const haveAQuestionsForm = document.querySelector(".page-7.have-a-questions");
if (haveAQuestionsForm) {
    const formContent = haveAQuestionsForm.querySelector(".page-7.have-a-questions .content");
    const afterSendContent = haveAQuestionsForm.querySelector(".page-7.have-a-questions  .after-send");
    const btnSubmit = haveAQuestionsForm.querySelector(".page-7.have-a-questions .btn-send");
    initFeedbackForm(".have-a-questions", {
        validateFields: {
            name: { required: true, selector: 'input[name="name"]' },
            email: { required: true, email: true, selector: 'input[name="email"]' },
            price: {
                required: true,
                selector: ".select-services-price",
                customSelect: true,
                messages: {
                    required: "Please select at least one service",
                },
            },
            services: {
                required: true,
                selector: ".select-services",
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
