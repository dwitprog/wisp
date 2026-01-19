import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { initFeedbackForm } from "../components/initFeedbackForm";

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
if (projectStagesSection) {
    const content = projectStagesSection.querySelector(".content");
    const lineContainer = projectStagesSection.querySelector(".line-container");
    const line = projectStagesSection.querySelector(".line-container .line");
    const circle = projectStagesSection.querySelector(".line-container .circle");
    const items = Array.from(projectStagesSection.querySelectorAll(".items .item"));
    const itemsContainer = projectStagesSection.querySelector(".items");

    if (content && lineContainer && line && circle && items.length && itemsContainer) {
        let lineHeight = 0;
        let circleHeight = 0;
        let maxTravel = 0;
        let lineContainerOffset = 0;
        let lineOffset = 0;
        let itemThresholds = [];
        let stopPoints = [];
        let contentPaddingTop = 0;

        const measure = () => {
            const sectionTop = projectStagesSection.getBoundingClientRect().top + window.scrollY;

            contentPaddingTop = parseFloat(getComputedStyle(content).paddingTop) || 0;
            lineHeight = line.offsetHeight;
            circleHeight = circle.offsetHeight;
            maxTravel = Math.max(0, lineHeight - circleHeight);
            lineContainerOffset = lineContainer.getBoundingClientRect().top + window.scrollY - sectionTop;
            lineOffset = line.getBoundingClientRect().top + window.scrollY - sectionTop;
            itemThresholds = items.map(item => item.getBoundingClientRect().top + window.scrollY - sectionTop + 6);
            stopPoints = [0, ...itemThresholds.map(threshold => threshold - lineOffset), maxTravel];
        };

        measure();
        gsap.set(circle, { y: 0 });

        ScrollTrigger.create({
            trigger: projectStagesSection,
            start: () => `top+=${contentPaddingTop} top`,
            end: () => `+=${Math.max(1, maxTravel)}`,
            pin: true,
            pinSpacing: true,
            scrub: true,
            onRefresh: measure,
            onUpdate: self => {
                const rawTravel = Math.min(maxTravel, Math.max(0, self.progress * maxTravel));
                let snappedTravel = stopPoints[0] ?? 0;

                for (let i = 1; i < stopPoints.length; i += 1) {
                    if (Math.abs(stopPoints[i] - rawTravel) < Math.abs(snappedTravel - rawTravel)) {
                        snappedTravel = stopPoints[i];
                    }
                }

                const travel = Math.min(maxTravel, Math.max(0, snappedTravel));
                gsap.set(circle, { y: travel });
                const circleTop = lineOffset + travel;
                let activeIndex = 0;

                for (let i = 0; i < itemThresholds.length; i += 1) {
                    if (circleTop >= itemThresholds[i]) {
                        activeIndex = i;
                    }
                }

                items.forEach((item, index) => {
                    item.classList.toggle("active", index <= activeIndex);
                });
            },
        });
    }
}

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
        const scrollLengthMultiplier = 2.5;
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

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
            start: () => `top+=${contentPaddingTop} top`,
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

                for (let i = 0; i < itemThresholds.length; i += 1) {
                    if (faderTop >= itemThresholds[i]) {
                        activeIndex = i;
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

                gsap.to(tweenState, {
                    value: targetScroll,
                    duration: 0.6,
                    ease: "power1.out",
                    onUpdate: () => {
                        faqTrigger.scroll(tweenState.value);
                    },
                });
            });
        });
    }
}

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
});
