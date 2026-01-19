import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export function initProjectStagesAnimation({
    section,
    contentSelector = ".content",
    lineContainerSelector = ".line-container",
    lineSelector = ".line",
    circleSelector = ".circle",
    itemsSelector = ".items .item",
    activeClass = "active",
    thresholdOffset = 6,
} = {}) {
    if (!section) return;

    const content = section.querySelector(contentSelector);
    const lineContainer = section.querySelector(lineContainerSelector);
    const line = section.querySelector(`${lineContainerSelector} ${lineSelector}`);
    const circle = section.querySelector(`${lineContainerSelector} ${circleSelector}`);
    const items = Array.from(section.querySelectorAll(itemsSelector));
    const itemsContainer = section.querySelector(".items");

    if (!content || !lineContainer || !line || !circle || !items.length || !itemsContainer) {
        return;
    }

    let lineHeight = 0;
    let circleHeight = 0;
    let maxTravel = 0;
    let lineContainerOffset = 0;
    let lineOffset = 0;
    let itemThresholds = [];
    let stopPoints = [];
    let contentPaddingTop = 0;

    const measure = () => {
        const sectionTop = section.getBoundingClientRect().top + window.scrollY;

        contentPaddingTop = parseFloat(getComputedStyle(content).paddingTop) || 0;
        lineHeight = line.offsetHeight;
        circleHeight = circle.offsetHeight;
        maxTravel = Math.max(0, lineHeight - circleHeight);

        lineContainerOffset = lineContainer.getBoundingClientRect().top + window.scrollY - sectionTop;
        lineOffset = line.getBoundingClientRect().top + window.scrollY - sectionTop;

        itemThresholds = items.map(
            item => item.getBoundingClientRect().top + window.scrollY - sectionTop + thresholdOffset,
        );

        stopPoints = [0, ...itemThresholds.map(threshold => threshold - lineOffset), maxTravel];
    };

    measure();
    gsap.set(circle, { y: 0 });

    ScrollTrigger.create({
        trigger: section,
        start: () => `top+=${contentPaddingTop} top`,
        end: () => `+=${Math.max(1, maxTravel)}`,
        pin: true,
        pinSpacing: true,
        scrub: true,
        onRefresh: measure,
        onUpdate: self => {
            const rawTravel = Math.min(maxTravel, Math.max(0, self.progress * maxTravel));

            let snappedTravel = stopPoints[0];

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
                item.classList.toggle(activeClass, index <= activeIndex);
            });
        },
    });
}
