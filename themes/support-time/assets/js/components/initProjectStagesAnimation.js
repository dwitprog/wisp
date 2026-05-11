import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export function initProjectStagesAnimation({
    section,
    contentSelector = ".content",
    lineContainerSelector = ".line-container",
    lineSelector = ".line",
    itemsSelector = ".items .item",
    textImageSelector = ".image .text img",
    activeClass = "active",
    thresholdOffset = 6,
    captureOffset = -100,
    textSwapMinDelay = 4000,
    textSwapMaxDelay = 7000,
    textSwapTransitionMs = 900,
    tailAfterLastStep = 200,
    onActiveStepChange = null,
} = {}) {
    if (!section) return;

    const content = section.querySelector(contentSelector);
    const lineContainer = section.querySelector(lineContainerSelector);
    const line = section.querySelector(`${lineContainerSelector} ${lineSelector}`);
    const items = Array.from(section.querySelectorAll(itemsSelector));
    const itemsContainer = section.querySelector(".items");
    const textImages = Array.from(section.querySelectorAll(textImageSelector));

    if (!content || !lineContainer || !line || !items.length || !itemsContainer) {
        return;
    }

    let lineHeight = 0;
    let stopPoints = [];
    let contentPaddingTop = 0;
    let entranceTrigger = null;
    let hasPlayedOnce = false;
    let sequenceTargets = [];
    let finalActiveIndex = -1;
    let itemThresholds = [];

    const measure = () => {
        const containerRect = lineContainer.getBoundingClientRect();
        const containerTop = containerRect.top + window.scrollY;
        contentPaddingTop = parseFloat(getComputedStyle(content).paddingTop) || 0;
        const stepData = items.map(item => {
            const step = item.querySelector(".step");
            const target = step || item;
            const targetRect = target.getBoundingClientRect();
            const start = targetRect.top + window.scrollY - targetRect.height;
            return {
                start: start + thresholdOffset,
                height: targetRect.height,
            };
        });

        itemThresholds = stepData.map(data => data.start);
        stopPoints = itemThresholds.map(threshold => threshold - containerTop);
        const lastStep = stepData[stepData.length - 1];
        const lastStop = stopPoints[stopPoints.length - 1] ?? 0;
        lineHeight = Math.max(0, lastStop + (lastStep?.height ?? 0) / 2 + Math.max(0, tailAfterLastStep));
        lineContainer.style.height = `${lineHeight}px`;
        sequenceTargets = stopPoints
            .map(point => Math.max(0, Math.min(lineHeight, point)))
            .filter((value, index, arr) => index === 0 || value > arr[index - 1]);

        if (!sequenceTargets.length) {
            sequenceTargets = [lineHeight];
        } else {
            const lastSeq = sequenceTargets[sequenceTargets.length - 1];
            if (lineHeight > lastSeq + 0.5) {
                sequenceTargets.push(lineHeight);
            }
        }

        finalActiveIndex = -1;
        const finalTarget = sequenceTargets[sequenceTargets.length - 1];
        for (let i = 0; i < stopPoints.length; i += 1) {
            if (finalTarget >= stopPoints[i]) {
                finalActiveIndex = i;
            } else {
                break;
            }
        }
    };

    const setActiveStep = index => {
        items.forEach((item, itemIndex) => {
            item.classList.toggle(activeClass, index >= 0 && itemIndex <= index);
            const step = item.querySelector(".step");
            if (step) {
                step.classList.toggle(activeClass, itemIndex === index);
            }
        });
        if (typeof onActiveStepChange === "function") {
            onActiveStepChange(index);
        }
    };

    const setInitialState = () => {
        measure();
        lineContainer.style.visibility = "hidden";
        lineContainer.style.height = "0";
        gsap.set(line, { height: 0 });
        setActiveStep(-1);
    };

    const playSequence = () => {
        if (hasPlayedOnce) {
            return;
        }
        hasPlayedOnce = true;
        section.classList.add("is-near");
        lineContainer.style.height = `${lineHeight}px`;
        lineContainer.style.visibility = "visible";

        const sequenceTimeline = gsap.timeline({
            defaults: { ease: "power2.inOut" },
        });

        sequenceTargets.forEach((targetHeight, index) => {
            let activeIndex = -1;
            for (let i = 0; i < stopPoints.length; i += 1) {
                if (targetHeight >= stopPoints[i]) {
                    activeIndex = i;
                } else {
                    break;
                }
            }

            sequenceTimeline.to(line, {
                height: targetHeight,
                duration: 0.7,
                onUpdate: () => {
                    setActiveStep(activeIndex);
                },
            });

            if (index < sequenceTargets.length - 1) {
                sequenceTimeline.to({}, { duration: 0.18 });
            }
        });

        sequenceTimeline.call(() => {
            setActiveStep(finalActiveIndex);
        });
    };

    const createEntranceTrigger = () => {
        if (entranceTrigger) {
            entranceTrigger.kill();
        }

        entranceTrigger = ScrollTrigger.create({
            trigger: section,
            start: () => `top+=${contentPaddingTop + Number(captureOffset)} 80%`,
            once: true,
            onRefresh: () => {
                if (!hasPlayedOnce) {
                    setInitialState();
                } else {
                    measure();
                    lineContainer.style.height = `${lineHeight}px`;
                    lineContainer.style.visibility = "visible";
                    gsap.set(line, { height: sequenceTargets[sequenceTargets.length - 1] || lineHeight });
                    setActiveStep(finalActiveIndex);
                }
            },
            onEnter: () => {
                playSequence();
            },
        });
    };

    setInitialState();
    createEntranceTrigger();
    if (entranceTrigger) {
        requestAnimationFrame(() => {
            entranceTrigger.refresh();
        });
        window.addEventListener("load", () => {
            measure();
            entranceTrigger?.refresh();
        });
        window.addEventListener("orientationchange", () => {
            setTimeout(() => {
                measure();
                if (!hasPlayedOnce) {
                    entranceTrigger?.refresh();
                    return;
                }
                lineContainer.style.height = `${lineHeight}px`;
                gsap.set(line, { height: sequenceTargets[sequenceTargets.length - 1] || lineHeight });
                setActiveStep(finalActiveIndex);
            }, 300);
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
        if (!hasPlayedOnce) {
            entranceTrigger?.refresh();
            return;
        }
        lineContainer.style.height = `${lineHeight}px`;
        lineContainer.style.visibility = "visible";
        gsap.set(line, { height: sequenceTargets[sequenceTargets.length - 1] || lineHeight });
        setActiveStep(finalActiveIndex);
    });
}
