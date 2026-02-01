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
    textImageSelector = ".image .text img",
    activeClass = "active",
    thresholdOffset = 6,
    scrollLengthMultiplier = 1.3,
    textSwapMinDelay = 4000,
    textSwapMaxDelay = 7000,
    textSwapTransitionMs = 900,
} = {}) {
    if (!section) return;

    const content = section.querySelector(contentSelector);
    const lineContainer = section.querySelector(lineContainerSelector);
    const line = section.querySelector(`${lineContainerSelector} ${lineSelector}`);
    const circle = section.querySelector(`${lineContainerSelector} ${circleSelector}`);
    const items = Array.from(section.querySelectorAll(itemsSelector));
    const itemsContainer = section.querySelector(".items");
    const textImages = Array.from(section.querySelectorAll(textImageSelector));

    if (!content || !lineContainer || !line || !circle || !items.length || !itemsContainer) {
        return;
    }

    let lineHeight = 0;
    let circleHeight = 0;
    let maxTravel = 0;
    let lineOffset = 0;
    let itemThresholds = [];
    let stopPoints = [];
    let contentPaddingTop = 0;
    let currentStopIndex = 0;
    let holdUntil = 0;
    const holdDurationMs = 500;
    let scrollTriggerInstance = null;
    let lineAnimationStarted = false;
    let lineAnimationCompleted = false;
    let lineTween = null;

    const measure = () => {
        const sectionTop = section.getBoundingClientRect().top + window.scrollY;

        contentPaddingTop = parseFloat(getComputedStyle(content).paddingTop) || 0;
        lineHeight = line.offsetHeight;
        circleHeight = circle.offsetHeight;
        const lineMaxTravel = Math.max(0, lineHeight - circleHeight);

        lineOffset = line.getBoundingClientRect().top + window.scrollY - sectionTop;

        itemThresholds = items.map(
            item => item.getBoundingClientRect().top + window.scrollY - sectionTop + thresholdOffset,
        );

        stopPoints = itemThresholds.map(threshold => threshold - lineOffset);
        const lastStop = stopPoints[stopPoints.length - 1];
        maxTravel = typeof lastStop === "number" ? Math.min(lineMaxTravel, Math.max(0, lastStop)) : lineMaxTravel;
        currentStopIndex = Math.min(currentStopIndex, Math.max(0, stopPoints.length - 1));
    };

    const setInitialState = () => {
        measure();
        line.style.transition = "none";
        gsap.set(line, { height: "100%", scaleY: 0, transformOrigin: "top" });
        gsap.set(circle, { y: stopPoints[0] || 0 });
        items.forEach((item, index) => {
            item.classList.toggle(activeClass, index === 0);
        });
    };

    const createScrollTrigger = () => {
        if (scrollTriggerInstance) {
            scrollTriggerInstance.kill();
        }
        const circleScrollLength = Math.max(maxTravel, window.innerHeight) * scrollLengthMultiplier;
        const totalLength = circleScrollLength;
        scrollTriggerInstance = ScrollTrigger.create({
            trigger: section,
            start: () => `top+=${contentPaddingTop} top`,
            end: () => `+=${totalLength}`,
            pin: true,
            pinSpacing: true,
            scrub: true,
            onRefresh: measure,
            onUpdate: self => {
                if (!stopPoints.length) {
                    return;
                }
                if (!lineAnimationStarted) {
                    lineAnimationStarted = true;
                    lineAnimationCompleted = false;
                    if (lineTween) {
                        lineTween.kill();
                    }
                    gsap.set(line, { scaleY: 0 });
                    lineTween = gsap.to(line, {
                        scaleY: 1,
                        duration: 0.5,
                        ease: "none",
                        onComplete: () => {
                            lineAnimationCompleted = true;
                        },
                    });
                }

                if (!lineAnimationCompleted) {
                    if (Math.abs(self.scroll() - self.start) > 1) {
                        self.scroll(self.start);
                    }
                    gsap.set(circle, { y: stopPoints[0] || 0 });
                    items.forEach((item, index) => {
                        item.classList.toggle(activeClass, index === 0);
                    });
                    return;
                }

                const rawTravel = Math.min(maxTravel, Math.max(0, self.progress * maxTravel));
                let desiredStopIndex = 0;
                let minDistance = Math.abs(stopPoints[0] - rawTravel);

                for (let i = 1; i < stopPoints.length; i += 1) {
                    const distance = Math.abs(stopPoints[i] - rawTravel);
                    if (distance < minDistance) {
                        minDistance = distance;
                        desiredStopIndex = i;
                    }
                }

                const now = performance.now();
                if (desiredStopIndex !== currentStopIndex && now < holdUntil) {
                    const travelProgress = maxTravel > 0 ? stopPoints[currentStopIndex] / maxTravel : 0;
                    const targetScroll = self.start + (self.end - self.start) * travelProgress;
                    if (Math.abs(self.scroll() - targetScroll) > 1) {
                        self.scroll(targetScroll);
                    }
                    return;
                }

                if (desiredStopIndex !== currentStopIndex) {
                    currentStopIndex = desiredStopIndex;
                    holdUntil = now + holdDurationMs;
                }

                const travel = Math.min(maxTravel, Math.max(0, stopPoints[currentStopIndex]));
                gsap.set(circle, { y: travel });

                items.forEach((item, index) => {
                    item.classList.toggle(activeClass, index <= currentStopIndex);
                });
            },
        });
    };

    setInitialState();
    createScrollTrigger();
    if (scrollTriggerInstance) {
        requestAnimationFrame(() => {
            scrollTriggerInstance.refresh();
        });
    }

    if (textImages.length > 1 && window.matchMedia("(min-width: 575.98px)")) {
        let activeTextIndex = textImages.findIndex(img => img.classList.contains(activeClass));
        if (activeTextIndex < 0) {
            activeTextIndex = 0;
            textImages[0].classList.add(activeClass);
        }

        const transitionMs = Math.max(0, textSwapTransitionMs);
        const scheduleNextSwap = () => {
            const minDelay = Math.max(0, textSwapMinDelay);
            const maxDelay = Math.max(minDelay, textSwapMaxDelay);
            const delay = minDelay + Math.random() * (maxDelay - minDelay);

            window.setTimeout(() => {
                const nextIndex = (activeTextIndex + 1) % textImages.length;

                textImages[activeTextIndex].classList.remove(activeClass);
                window.setTimeout(() => {
                    textImages[nextIndex].classList.add(activeClass);
                    activeTextIndex = nextIndex;

                    window.setTimeout(scheduleNextSwap, transitionMs);
                }, transitionMs);
            }, delay);
        };

        scheduleNextSwap();
    }

    window.addEventListener("resize", () => {
        measure();
        if (scrollTriggerInstance) {
            scrollTriggerInstance.refresh();
        }
    });
}
