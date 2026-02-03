import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const howWeWorkSection = document.querySelector(".page-46.how-we-work");
const bannerSection = document.querySelector(".page-46.banner");

if (bannerSection) {
    const wrapper = bannerSection.querySelector(".coordinates-wrapper");
    const lineTop = bannerSection.querySelector(".coordinate-axis.line-top .line");
    const lineRight = bannerSection.querySelector(".coordinate-axis.line-right .line");
    const items = Array.from(bannerSection.querySelectorAll(".items .item"));
    const labels = Array.from(bannerSection.querySelectorAll(".coordinate-axis .label"));

    if (wrapper && lineTop && lineRight && items.length) {
        const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        const smallScreen = window.matchMedia("(max-width: 575.98px)").matches;
        const itemParts = items.map(item => ({
            item,
            content: item.querySelector(".content"),
            line: item.querySelector(".line"),
            number: item.querySelector(".number"),
        }));
        const itemContents = itemParts.map(part => part.content).filter(Boolean);
        const itemLines = itemParts.map(part => part.line).filter(Boolean);
        const itemNumbers = itemParts.map(part => part.number).filter(Boolean);

        const setFinalState = () => {
            gsap.set([lineTop, lineRight], { scaleX: 1, scaleY: 1 });
            gsap.set(itemContents, { height: "auto", overflow: "visible" });
            gsap.set(itemLines, { clearProps: "height" });
            gsap.set(itemNumbers, { autoAlpha: 1, visibility: "visible" });
            gsap.set(labels, { autoAlpha: 1, visibility: "visible" });
        };

        if (reduceMotion || smallScreen) {
            setFinalState();
        } else {
            let maxWidth = 0;
            let itemThresholds = [];
            let lineHeights = [];
            const revealedItems = new Set();

            const getLineHeight = line => {
                const prevHeight = line.style.height;
                line.style.height = "";
                const height = line.offsetHeight;
                line.style.height = prevHeight;
                return height;
            };

            const measure = () => {
                const lineRect = lineRight.getBoundingClientRect();
                maxWidth = lineRight.offsetWidth;
                itemThresholds = items.map(item => {
                    const itemRect = item.getBoundingClientRect();
                    return itemRect.left + itemRect.width / 2 - lineRect.left;
                });
                lineHeights = itemParts.map(part => (part.line ? getLineHeight(part.line) : 0));
            };

            measure();

            gsap.set(lineTop, { scaleY: 0, transformOrigin: "bottom left" });
            gsap.set(lineRight, { scaleX: 0, transformOrigin: "left center" });
            gsap.set(itemContents, { height: 0, overflow: "hidden" });
            gsap.set(itemLines, { height: 0 });
            gsap.set(itemNumbers, { autoAlpha: 0, visibility: "hidden" });
            gsap.set(labels, { autoAlpha: 0, visibility: "hidden" });

            const revealItem = index => {
                const part = itemParts[index];
                if (!part || revealedItems.has(index)) return;
                revealedItems.add(index);

                if (part.content) {
                    gsap.to(part.content, {
                        height: "auto",
                        duration: 0.34,
                        ease: "none",
                        overwrite: "auto",
                    });
                }

                if (part.line) {
                    gsap.to(part.line, {
                        height: lineHeights[index] || 0,
                        duration: 0.34,
                        ease: "none",
                        overwrite: "auto",
                    });
                }

                if (part.number) {
                    gsap.to(part.number, {
                        autoAlpha: 1,
                        duration: 0.34,
                        ease: "none",
                        overwrite: "auto",
                    });
                }
            };

            const timeline = gsap.timeline({
                defaults: { ease: "none" },
                onUpdate: () => {
                    const progress = gsap.getProperty(lineRight, "scaleX");
                    const currentWidth = maxWidth * progress;

                    itemThresholds.forEach((threshold, index) => {
                        if (currentWidth >= threshold) {
                            revealItem(index);
                        }
                    });
                },
            });

            timeline
                .to(lineTop, { scaleY: 1, duration: 2 }, 0)
                .to(lineRight, { scaleX: 1, duration: 2 }, 0)
                .to(labels, { autoAlpha: 1, visibility: "visible", duration: 0.5 }, ">-0.1");

            ScrollTrigger.create({
                trigger: wrapper,
                start: "top 80%",
                once: true,
                onEnter: () => timeline.play(0),
                onRefresh: measure,
            });

            window.addEventListener("resize", () => {
                measure();
            });
        }
    }
}

if (howWeWorkSection) {
    const lineContainer = howWeWorkSection.querySelector(".line-container");
    const line = howWeWorkSection.querySelector(".line-container .line");
    const circle = howWeWorkSection.querySelector(".line-container .circle");
    const items = Array.from(howWeWorkSection.querySelectorAll(".items .item"));
    const knob = howWeWorkSection.querySelector(".service-knob .knob");

    if (lineContainer && line && items.length && knob) {
        const stepClasses = ["step_2", "step_3", "step_4"];
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        const isTouchDevice = () => "ontouchstart" in window || navigator.maxTouchPoints > 0;
        const thresholdOffset = 0;
        const scrollLengthMultiplier = 1.3;
        const tailAfterLastStep = 150;
        const stepHoldMs = 500;
        const captureOffset = -100;
        const touchDeltaMultiplier = 2.5;

        let lineHeight = 0;
        let maxTravel = 0;
        let itemThresholds = [];
        let stopPoints = [];
        let stopPositions = [];
        let circleStops = [];
        let contentPaddingTop = 0;
        let scrollTriggerInstance = null;
        let currentSegmentIndex = -1;
        let currentTargetIndex = 0;
        let holdUntil = 0;
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
        let totalLength = 0;
        let bottomCompleteTimeline = null;

        const setKnobStepByIndex = index => {
            const stepNumber = clamp(index + 2, 2, 4);
            const nextClass = `step_${stepNumber}`;
            knob.classList.remove(...stepClasses);
            knob.classList.add(nextClass);
        };

        const setActiveStep = index => {
            items.forEach((item, itemIndex) => {
                item.classList.toggle("active", index >= 0 && itemIndex <= index);
                const step = item.querySelector(".step");
                if (step) {
                    step.classList.toggle("active", itemIndex === index);
                }
            });
            if (index >= 0) {
                setKnobStepByIndex(index);
            }
        };

        const measure = () => {
            const containerRect = lineContainer.getBoundingClientRect();
            const containerTop = containerRect.top + window.scrollY;
            contentPaddingTop = parseFloat(getComputedStyle(howWeWorkSection).paddingTop) || 0;

            const stepData = items.map(item => {
                const stepEl = item.querySelector(".step");
                const target = stepEl || item;
                const rect = target.getBoundingClientRect();
                const center = rect.top + window.scrollY + rect.height / 2;
                return {
                    center: center + thresholdOffset,
                    height: rect.height,
                };
            });

            itemThresholds = stepData.map(data => data.center);
            stopPoints = itemThresholds.map(threshold => threshold - containerTop);
            const lastStep = stepData[stepData.length - 1];
            const lastStop = stopPoints[stopPoints.length - 1] ?? 0;
            lineHeight = Math.max(0, lastStop + (lastStep?.height ?? 0) / 2 + Math.max(0, tailAfterLastStep));
            const lineMaxTravel = Math.max(0, lineHeight);
            lineContainer.style.height = `${lineHeight}px`;
            maxTravel = lineMaxTravel;
            stopPositions = [0, ...stopPoints.map(point => Math.min(lineMaxTravel, Math.max(0, point))), lineMaxTravel];
            const circleHeight = circle ? circle.offsetHeight : 0;
            circleStops = stopPositions.map(pos => Math.max(0, pos - circleHeight / 2));
        };

        const getStopPosition = index => {
            if (!stopPositions.length) return 0;
            const rawStop = stopPositions[index] ?? stopPositions[0] ?? 0;
            return Math.min(maxTravel, Math.max(0, rawStop));
        };

        const getCirclePosition = index => {
            if (!circleStops.length) return 0;
            const rawStop = circleStops[index] ?? circleStops[0] ?? 0;
            return Math.min(maxTravel, Math.max(0, rawStop));
        };

        const setInitialState = () => {
            measure();
            lineContainer.style.visibility = "hidden";
            lineContainer.style.height = "0";
            line.style.transition = "none";
            gsap.set(line, { height: 0 });
            if (circle) {
                gsap.set(circle, { y: getCirclePosition(0) });
            }
            setActiveStep(-1);
            currentSegmentIndex = -1;
            currentTargetIndex = 0;
            holdUntil = 0;
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
            if (circle) {
                gsap.set(circle, { y: getCirclePosition(stopPositions.length - 1) });
            }
            setActiveStep(stopPoints.length - 1);
        };

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
            if (!stopPositions.length) return;
            const clampedProgress = Math.max(0, Math.min(1, progress));
            if (clampedProgress < 1) {
                hasCompleted = false;
            }
            const segmentCount = Math.max(1, stopPositions.length - 1);
            const scaled = clampedProgress * segmentCount;
            const segmentIndex = Math.min(segmentCount - 1, Math.floor(scaled));
            const targetIndex = clampedProgress === 0 ? 0 : Math.min(stopPositions.length - 1, segmentIndex + 1);

            const now = performance.now();
            if (now < holdUntil) return;

            if (segmentIndex !== currentSegmentIndex || targetIndex !== currentTargetIndex) {
                currentSegmentIndex = segmentIndex;
                currentTargetIndex = targetIndex;
                holdUntil = now + Math.max(0, stepHoldMs);
                const targetHeight = getStopPosition(targetIndex);
                const targetCircle = getCirclePosition(targetIndex);
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
                if (circle) {
                    gsap.killTweensOf(circle);
                    gsap.to(circle, {
                        y: targetCircle,
                        duration: 0.6,
                        ease: "none",
                    });
                }
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

        const startBottomCompletion = () => {
            if (bottomCompleteTimeline || !stopPositions.length) {
                return;
            }
            const segmentCount = Math.max(1, stopPositions.length - 1);
            const startIndex = Math.max(1, currentTargetIndex);

            bottomCompleteTimeline = gsap.timeline({
                onComplete: () => {
                    bottomCompleteTimeline = null;
                    mobileMaxProgress = 1;
                    updateByProgress(1);
                },
            });

            for (let i = startIndex; i < stopPositions.length; i += 1) {
                const targetHeight = getStopPosition(i);
                const targetCircle = getCirclePosition(i);
                bottomCompleteTimeline.to(line, { height: targetHeight, duration: 0.5, ease: "none" }, ">");
                if (circle) {
                    bottomCompleteTimeline.to(circle, { y: targetCircle, duration: 0.5, ease: "none" }, "<");
                }
                bottomCompleteTimeline.call(() => {
                    const activeIndex = Math.min(items.length - 1, i - 1);
                    setActiveStep(activeIndex);
                    currentTargetIndex = i;
                    currentSegmentIndex = Math.max(0, i - 1);
                    maxProgress = segmentCount > 0 ? i / segmentCount : 0;
                });
                bottomCompleteTimeline.to({}, { duration: 0.3 });
            }
        };

        const handleDelta = delta => {
            if (!isLocked) return;
            if (delta <= 0) return;
            const now = performance.now();
            if (now < holdUntil) return;
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
            if (!isLocked) return;
            if (event.deltaY < 0) {
                event.preventDefault();
                event.stopPropagation();
                return;
            }
            event.preventDefault();
            handleDelta(event.deltaY);
        };

        const onUnlockKey = event => {
            if (event.key === "Escape" || event.key === "ArrowUp") {
                event.preventDefault();
                event.stopPropagation();
            }
        };

        const addUnlockKeyListener = () => {
            window.addEventListener("keydown", onUnlockKey, { capture: true });
        };

        const removeUnlockKeyListener = () => {
            window.removeEventListener("keydown", onUnlockKey, { capture: true });
        };

        const onTouchStart = event => {
            if (!isLocked || hasCompleted) return;
            touchStartY = event.touches[0].clientY;
        };

        const onTouchMove = event => {
            if (!isLocked) return;
            const currentY = event.touches[0].clientY;
            const deltaY = touchStartY - currentY;
            touchStartY = currentY;
            if (deltaY > 0) {
                event.preventDefault();
                event.stopPropagation();
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
        const getSectionBottomGap = () => {
            const sectionRect = howWeWorkSection.getBoundingClientRect();
            return sectionRect.bottom - window.innerHeight;
        };

        const createScrollTrigger = () => {
            if (scrollTriggerInstance) {
                scrollTriggerInstance.kill();
            }
            totalLength = Math.max(maxTravel, 1) * Math.max(0.1, scrollLengthMultiplier);

            if (isTouchDevice()) {
                const getMobileProgressFromScroll = (scrollY, triggerStart, triggerEnd) => {
                    if (itemThresholds.length === 0) return 0;
                    if (scrollY <= triggerStart) return 0;
                    const lastThreshold = itemThresholds[itemThresholds.length - 1];
                    const endY = lastThreshold + Math.max(200, tailAfterLastStep);
                    if (scrollY >= endY) return 1;
                    const segmentCount = itemThresholds.length;
                    const startY = triggerStart;
                    for (let i = 0; i < segmentCount; i += 1) {
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
                    const sectionTop = howWeWorkSection.getBoundingClientRect().top + window.scrollY;
                    const lastThreshold = itemThresholds[itemThresholds.length - 1];
                    const triggerStartY = sectionTop + contentPaddingTop + mobileCaptureOffset;
                    return Math.max(totalLength, lastThreshold - triggerStartY + Math.max(200, tailAfterLastStep));
                };

                scrollTriggerInstance = ScrollTrigger.create({
                    trigger: howWeWorkSection,
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
                        if (scrollY >= triggerStart && getSectionBottomGap() <= 20) {
                            startBottomCompletion();
                            return;
                        }
                        if (bottomCompleteTimeline) {
                            return;
                        }
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
                    trigger: howWeWorkSection,
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

        window.addEventListener("resize", () => {
            measure();
            if (scrollTriggerInstance) {
                scrollTriggerInstance.refresh();
            }
        });
    }
}
