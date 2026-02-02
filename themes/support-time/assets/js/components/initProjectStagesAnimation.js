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
    scrollLengthMultiplier = 1.3,
    textSwapMinDelay = 4000,
    textSwapMaxDelay = 7000,
    textSwapTransitionMs = 900,
    tailAfterLastStep = 200,
    stepHoldMs = 300,
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
    let maxTravel = 0;
    let itemThresholds = [];
    let stopPoints = [];
    let contentPaddingTop = 0;
    let scrollTriggerInstance = null;
    let pulseTween = null;
    let stopPositions = [];
    let currentSegmentIndex = -1;
    let currentTargetIndex = 0;
    let holdUntil = 0;
    let holdScroll = null;
    let maxProgress = 0;
    let hasCompleted = false;
    let isCleaning = false;
    let isLocked = false;
    let savedScrollY = 0;
    let touchStartY = 0;
    let lastStepAt = 0;
    let pendingUnlockTimer = null;

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
        const lineMaxTravel = Math.max(0, lineHeight);
        lineContainer.style.height = `${lineHeight}px`;
        maxTravel = lineMaxTravel;
        stopPositions = [0, ...stopPoints.map(point => Math.min(lineMaxTravel, Math.max(0, point))), lineMaxTravel];
    };

    const getStopPosition = index => {
        if (!stopPositions.length) {
            return 0;
        }
        const rawStop = stopPositions[index] ?? stopPositions[0] ?? 0;
        return Math.min(maxTravel, Math.max(0, rawStop));
    };

    const setActiveStep = index => {
        items.forEach((item, itemIndex) => {
            item.classList.toggle(activeClass, index >= 0 && itemIndex <= index);
            const step = item.querySelector(".step");
            if (step) {
                step.classList.toggle(activeClass, itemIndex === index);
            }
        });
    };

    const setInitialState = () => {
        measure();
        line.style.transition = "none";
        gsap.set(line, { height: 0 });
        setActiveStep(-1);
        currentSegmentIndex = -1;
        currentTargetIndex = 0;
        holdUntil = 0;
        holdScroll = null;
        maxProgress = 0;
        hasCompleted = false;
        isCleaning = false;
        isLocked = false;
        savedScrollY = 0;
        touchStartY = 0;
        lastStepAt = 0;
        if (pendingUnlockTimer) {
            window.clearTimeout(pendingUnlockTimer);
            pendingUnlockTimer = null;
        }
    };

    const setFinalState = () => {
        measure();
        gsap.set(line, { height: lineHeight });
        setActiveStep(stopPoints.length - 1);
    };

    const createScrollTrigger = () => {
        if (scrollTriggerInstance) {
            scrollTriggerInstance.kill();
        }
        const totalLength = Math.max(maxTravel, 1) * Math.max(0.1, scrollLengthMultiplier);
        if (pulseTween) {
            pulseTween.kill();
            pulseTween = null;
        }

        const lockScroll = () => {
            if (isLocked) return;
            isLocked = true;
            savedScrollY = window.scrollY;
            document.body.style.position = "fixed";
            document.body.style.top = `-${savedScrollY}px`;
            document.body.style.left = "0";
            document.body.style.right = "0";
        };

        const unlockScroll = () => {
            if (!isLocked) return;
            isLocked = false;
            document.body.style.position = "";
            document.body.style.top = "";
            document.body.style.left = "";
            document.body.style.right = "";
            window.scrollTo(0, savedScrollY);
        };

        const updateByProgress = progress => {
            if (!stopPositions.length || hasCompleted) {
                return;
            }
            const clampedProgress = Math.max(0, Math.min(1, progress));
            const segmentCount = Math.max(1, stopPositions.length - 1);
            const scaled = clampedProgress * segmentCount;
            const segmentIndex = Math.min(segmentCount - 1, Math.floor(scaled));
            const targetIndex = clampedProgress === 0 ? 0 : Math.min(stopPositions.length - 1, segmentIndex + 1);

            const now = performance.now();
            if (now < holdUntil) {
                return;
            }

            if (segmentIndex !== currentSegmentIndex || targetIndex !== currentTargetIndex) {
                currentSegmentIndex = segmentIndex;
                currentTargetIndex = targetIndex;
                holdUntil = now + Math.max(0, stepHoldMs);
                const targetHeight = getStopPosition(targetIndex);
                gsap.killTweensOf(line);
                gsap.to(line, {
                    height: targetHeight,
                    duration: 0.6,
                    ease: "none",
                });
                lastStepAt = now;

                const activeIndex = Math.min(items.length - 1, targetIndex - 1);
                setActiveStep(activeIndex);

                maxProgress = segmentCount > 0 ? targetIndex / segmentCount : 0;
            }

            if (clampedProgress >= 1) {
                hasCompleted = true;
                setFinalState();
                unlockScroll();
                removeInputListeners();
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                    pendingUnlockTimer = null;
                }
                if (scrollTriggerInstance) {
                    scrollTriggerInstance.kill();
                    scrollTriggerInstance = null;
                }
            }
        };

        const handleDelta = delta => {
            if (!isLocked || hasCompleted) {
                return;
            }
            const now = performance.now();
            if (now < holdUntil) {
                return;
            }
            const speed = Math.max(0.1, scrollLengthMultiplier);
            const deltaProgress = delta / (totalLength * speed);
            maxProgress = Math.max(0, Math.min(1, maxProgress + deltaProgress));
            updateByProgress(maxProgress);

            if (delta > 0) {
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                }
                const inputTime = now;
                pendingUnlockTimer = window.setTimeout(
                    () => {
                        if (isLocked && !hasCompleted && lastStepAt < inputTime) {
                            unlockScroll();
                            removeInputListeners();
                        }
                    },
                    Math.max(600, stepHoldMs + 500),
                );
            }
        };

        const onWheel = event => {
            if (!isLocked || hasCompleted) {
                return;
            }
            event.preventDefault();
            if (event.deltaY > 0) {
                handleDelta(event.deltaY);
            }
        };

        const onTouchStart = event => {
            if (!isLocked || hasCompleted) {
                return;
            }
            touchStartY = event.touches[0].clientY;
        };

        const onTouchMove = event => {
            if (!isLocked || hasCompleted) {
                return;
            }
            event.preventDefault();
            const currentY = event.touches[0].clientY;
            const deltaY = touchStartY - currentY;
            touchStartY = currentY;
            if (deltaY > 0) {
                handleDelta(deltaY);
            }
        };

        const addInputListeners = () => {
            window.addEventListener("wheel", onWheel, { passive: false });
            window.addEventListener("touchstart", onTouchStart, { passive: false });
            window.addEventListener("touchmove", onTouchMove, { passive: false });
        };

        const removeInputListeners = () => {
            window.removeEventListener("wheel", onWheel);
            window.removeEventListener("touchstart", onTouchStart);
            window.removeEventListener("touchmove", onTouchMove);
        };

        scrollTriggerInstance = ScrollTrigger.create({
            trigger: section,
            start: () => `top+=${contentPaddingTop} top`,
            end: () => `+=${totalLength}`,
            onRefresh: () => {
                setInitialState();
            },
            onEnter: () => {
                if (hasCompleted || isCleaning) {
                    return;
                }
                lockScroll();
                addInputListeners();
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
