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
    headerSelector = "#header.header, header#header",
    lockTopExtra = 0,
    captureOffset = -100,
    textSwapMinDelay = 4000,
    textSwapMaxDelay = 7000,
    textSwapTransitionMs = 900,
    tailAfterLastStep = 200,
    stepHoldMs = 700,
    touchDeltaMultiplier = 2.5,
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

    const headerEl = document.querySelector(headerSelector);
    const getHeaderHeight = () => (headerEl ? headerEl.offsetHeight : 0);
    const isTouchDevice = () => "ontouchstart" in window || navigator.maxTouchPoints > 0;

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
    let hasEnteredOnce = false;
    let savedScrollY = 0;
    let touchStartY = 0;
    let lastStepAt = 0;
    let pendingUnlockTimer = null;
    let mobileMaxProgress = 0;
    let pendingActiveIndex = -1;

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
            item.classList.toggle(activeClass, index >= 0 && itemIndex === index);
            const step = item.querySelector(".step");
            if (step) {
                step.classList.toggle(activeClass, itemIndex === index);
            }
        });
    };

    const setInitialState = () => {
        measure();
        lineContainer.style.visibility = "hidden";
        lineContainer.style.height = "0";
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
        hasEnteredOnce = false;
        savedScrollY = 0;
        touchStartY = 0;
        lastStepAt = 0;
        pendingActiveIndex = -1;
        if (pendingUnlockTimer) {
            window.clearTimeout(pendingUnlockTimer);
            pendingUnlockTimer = null;
        }
        if (!isTouchDevice()) {
            mobileMaxProgress = 0;
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
            const currentScroll = window.scrollY;
            const triggerStart = scrollTriggerInstance?.start ?? currentScroll;
            savedScrollY = Math.min(currentScroll, triggerStart);
            if (!isTouchDevice()) {
                const docEl = document.documentElement;
                docEl.style.overflow = "hidden";
                docEl.style.height = "100%";
                document.body.style.position = "fixed";
                document.body.style.top = `-${savedScrollY}px`;
                document.body.style.left = "0";
                document.body.style.right = "0";
                document.body.style.overflow = "hidden";
                document.body.style.width = "100%";
                document.body.style.webkitOverflowScrolling = "auto";
            }
        };

        const unlockScroll = () => {
            if (!isLocked) return;
            isLocked = false;
            if (!isTouchDevice()) {
                const docEl = document.documentElement;
                docEl.style.overflow = "";
                docEl.style.height = "";
                document.body.style.position = "";
                document.body.style.top = "";
                document.body.style.left = "";
                document.body.style.right = "";
                document.body.style.overflow = "";
                document.body.style.width = "";
                document.body.style.webkitOverflowScrolling = "";
            }
            window.scrollTo(0, savedScrollY);
        };

        const updateByProgress = progress => {
            if (!stopPositions.length) {
                return;
            }
            const clampedProgress = Math.max(0, Math.min(1, progress));
            if (clampedProgress < 1) {
                hasCompleted = false;
            }
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
                    onComplete: () => {
                        if (isCleaning) return;
                        if (currentTargetIndex !== targetIndex) return;
                        setActiveStep(pendingActiveIndex);
                    },
                });
                lastStepAt = now;

                pendingActiveIndex = Math.min(items.length - 1, targetIndex - 1);

                maxProgress = segmentCount > 0 ? targetIndex / segmentCount : 0;
            }

            if (clampedProgress >= 1) {
                hasCompleted = true;
                setFinalState();
                if (!isTouchDevice()) {
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
            }
        };

        const handleDelta = delta => {
            if (!isLocked) {
                return;
            }
            if (delta <= 0) {
                unlockScroll();
                removeInputListeners();
                removeUnlockKeyListener();
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                    pendingUnlockTimer = null;
                }
                return;
            }
            const now = performance.now();
            if (now < holdUntil) {
                return;
            }
            const speed = Math.max(0.1, scrollLengthMultiplier);
            const deltaProgress = delta / (totalLength * speed);
            maxProgress = Math.max(0, Math.min(1, maxProgress + deltaProgress));
            if (maxProgress < 1) {
                hasCompleted = false;
            }
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
            if (!isLocked) {
                return;
            }
            if (event.deltaY < 0) {
                event.preventDefault();
                event.stopPropagation();
                unlockScroll();
                removeInputListeners();
                removeUnlockKeyListener();
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                    pendingUnlockTimer = null;
                }
                return;
            }
            event.preventDefault();
            handleDelta(event.deltaY);
        };

        const onUnlockKey = event => {
            if (event.key === "Escape" || event.key === "ArrowUp") {
                event.preventDefault();
                unlockScroll();
                removeInputListeners();
                removeUnlockKeyListener();
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                    pendingUnlockTimer = null;
                }
            }
        };

        const addUnlockKeyListener = () => {
            window.addEventListener("keydown", onUnlockKey, { capture: true });
        };

        const removeUnlockKeyListener = () => {
            window.removeEventListener("keydown", onUnlockKey, { capture: true });
        };

        const onTouchStart = event => {
            if (!isLocked || hasCompleted) {
                return;
            }
            touchStartY = event.touches[0].clientY;
        };

        const onTouchMove = event => {
            if (!isLocked) {
                return;
            }
            const currentY = event.touches[0].clientY;
            const deltaY = touchStartY - currentY;
            touchStartY = currentY;
            if (deltaY > 0) {
                event.preventDefault();
                event.stopPropagation();
                unlockScroll();
                removeInputListeners();
                removeUnlockKeyListener();
                if (pendingUnlockTimer) {
                    window.clearTimeout(pendingUnlockTimer);
                    pendingUnlockTimer = null;
                }
                return;
            }
            event.preventDefault();
            event.stopPropagation();
            const baseDelta = Math.abs(deltaY) * Math.max(0.5, Number(touchDeltaMultiplier));
            const touchDivisor = isTouchDevice() ? 5 : 1;
            const scaledDelta = baseDelta / touchDivisor;
            handleDelta(scaledDelta);
        };

        const addInputListeners = () => {
            document.documentElement.addEventListener("wheel", onWheel, { passive: false, capture: true });
            addUnlockKeyListener();
            document.body.addEventListener("touchstart", onTouchStart, { passive: false, capture: true });
            document.body.addEventListener("touchmove", onTouchMove, { passive: false, capture: true });
        };

        const removeInputListeners = () => {
            document.documentElement.removeEventListener("wheel", onWheel, { capture: true });
            removeUnlockKeyListener();
            document.body.removeEventListener("touchstart", onTouchStart, { capture: true });
            document.body.removeEventListener("touchmove", onTouchMove, { capture: true });
        };

        const mobileCaptureOffset = isTouchDevice() ? Number(captureOffset) - 60 : Number(captureOffset);

        if (isTouchDevice()) {
            const getMobileProgressFromScroll = (scrollY, triggerStart, triggerEnd) => {
                if (itemThresholds.length === 0) return 0;
                if (scrollY <= triggerStart) return 0;
                const lastThreshold = itemThresholds[itemThresholds.length - 1];
                const endY = lastThreshold + Math.max(200, tailAfterLastStep);
                if (scrollY >= endY) return 1;
                const segmentCount = itemThresholds.length;
                const startY = triggerStart;
                for (let i = 0; i < segmentCount; i++) {
                    const segStart = i === 0 ? startY : itemThresholds[i - 1];
                    const segEnd = itemThresholds[i];
                    if (scrollY < segEnd) {
                        const segLen = segEnd - segStart;
                        const segProgress = segLen > 0 ? (scrollY - segStart) / segLen : 0;
                        return Math.min(1, (i + segProgress) / segmentCount);
                    }
                }
                return Math.min(
                    1,
                    (segmentCount -
                        1 +
                        (scrollY - itemThresholds[segmentCount - 1]) / (endY - itemThresholds[segmentCount - 1])) /
                        segmentCount,
                );
            };

            const mobileEndLength = () => {
                if (itemThresholds.length === 0) return totalLength;
                const sectionTop = section.getBoundingClientRect().top + window.scrollY;
                const lastThreshold = itemThresholds[itemThresholds.length - 1];
                const triggerStartY = sectionTop + contentPaddingTop + mobileCaptureOffset;
                return Math.max(totalLength, lastThreshold - triggerStartY + Math.max(200, tailAfterLastStep));
            };

            scrollTriggerInstance = ScrollTrigger.create({
                trigger: section,
                start: () => `top+=${contentPaddingTop + mobileCaptureOffset} top`,
                end: () => `+=${mobileEndLength()}`,
                onRefresh: () => {
                    measure();
                },
                onUpdate: self => {
                    const now = performance.now();
                    const scrollY = window.scrollY;
                    const triggerStart = self.start;
                    if (scrollY > triggerStart) {
                        measure();
                        if (lineContainer.style.visibility !== "visible") {
                            lineContainer.style.height = `${lineHeight}px`;
                            lineContainer.style.visibility = "visible";
                        }
                    }
                    const rawProgress = getMobileProgressFromScroll(scrollY, triggerStart, self.end);
                    if (rawProgress > 0) {
                        const nextProgress =
                            now < holdUntil ? mobileMaxProgress : Math.max(mobileMaxProgress, rawProgress);
                        mobileMaxProgress = nextProgress;
                        updateByProgress(mobileMaxProgress);
                    } else {
                        updateByProgress(mobileMaxProgress);
                    }
                },
            });
        } else {
            scrollTriggerInstance = ScrollTrigger.create({
                trigger: section,
                start: () => `top+=${contentPaddingTop + mobileCaptureOffset} top`,
                end: () => `+=${totalLength}`,
                onRefresh: () => {
                    setInitialState();
                },
                onEnter: () => {
                    if (hasEnteredOnce || hasCompleted || isCleaning) {
                        return;
                    }
                    hasEnteredOnce = true;
                    measure();
                    lineContainer.style.height = `${lineHeight}px`;
                    lineContainer.style.visibility = "visible";
                    lockScroll();
                    addInputListeners();
                },
            });
        }
    };

    setInitialState();
    createScrollTrigger();
    if (scrollTriggerInstance) {
        requestAnimationFrame(() => {
            scrollTriggerInstance.refresh();
        });
        window.addEventListener("load", () => {
            measure();
            scrollTriggerInstance?.refresh();
        });
        window.addEventListener("orientationchange", () => {
            setTimeout(() => {
                measure();
                scrollTriggerInstance?.refresh();
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
        if (scrollTriggerInstance) {
            scrollTriggerInstance.refresh();
        }
    });
}
