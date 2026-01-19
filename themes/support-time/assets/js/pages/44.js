import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
// Анимация секции faq (pin + движение фейдера)
const faqSection = document.querySelector(".page-44.faq");
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
