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
        let itemThresholds = [];
        let contentPaddingTop = 0;

        const measure = () => {
            const sectionTop = projectStagesSection.getBoundingClientRect().top + window.scrollY;

            contentPaddingTop = parseFloat(getComputedStyle(content).paddingTop) || 0;
            lineHeight = line.offsetHeight;
            circleHeight = circle.offsetHeight;
            maxTravel = Math.max(0, lineHeight - circleHeight);
            lineContainerOffset = lineContainer.getBoundingClientRect().top + window.scrollY - sectionTop;
            itemThresholds = items.map(item => item.getBoundingClientRect().top + window.scrollY - sectionTop + 12);
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
                const travel = Math.min(maxTravel, Math.max(0, self.progress * maxTravel));
                gsap.set(circle, { y: travel });
                const circleTop = lineContainerOffset + travel;
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
