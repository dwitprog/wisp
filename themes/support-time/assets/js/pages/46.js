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

    if (lineContainer && line && circle && items.length && knob) {
        const stepClasses = ["step_2", "step_3", "step_4"];
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        const thresholdOffset = 0;
        const scrollLengthMultiplier = 1.3;
        const holdDurationMs = 500;

        let lineOffset = 0;
        let circleHeight = 0;
        let maxTravel = 0;
        let itemThresholds = [];
        let stopPoints = [];
        let contentPaddingTop = 0;
        let currentStopIndex = 0;
        let holdUntil = 0;
        let scrollTriggerInstance = null;
        let lineAnimationStarted = false;
        let lineAnimationCompleted = false;
        let lineTween = null;

        const setKnobStepByIndex = index => {
            const stepNumber = clamp(index + 2, 2, 4);
            const nextClass = `step_${stepNumber}`;
            knob.classList.remove(...stepClasses);
            knob.classList.add(nextClass);
        };

        const measure = () => {
            const sectionTop = howWeWorkSection.getBoundingClientRect().top + window.scrollY;

            contentPaddingTop = parseFloat(getComputedStyle(howWeWorkSection).paddingTop) || 0;
            circleHeight = circle.offsetHeight;
            lineOffset = line.getBoundingClientRect().top + window.scrollY - sectionTop;
            const lineMaxTravel = Math.max(0, line.offsetHeight - circleHeight);
            itemThresholds = items.map(item => {
                const stepEl = item.querySelector(".step");
                const target = stepEl || item;
                const rect = target.getBoundingClientRect();
                const center = rect.top + window.scrollY + rect.height / 2;
                return center - sectionTop + thresholdOffset;
            });
            stopPoints = itemThresholds.map(threshold => threshold - lineOffset - circleHeight / 2);
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
                item.classList.toggle("active", index === 0);
            });
            setKnobStepByIndex(0);
        };

        const createScrollTrigger = () => {
            if (scrollTriggerInstance) {
                scrollTriggerInstance.kill();
            }
            const circleScrollLength = Math.max(maxTravel, window.innerHeight) * scrollLengthMultiplier;
            scrollTriggerInstance = ScrollTrigger.create({
                trigger: howWeWorkSection,
                start: () => `top+=${contentPaddingTop} top`,
                end: () => `+=${circleScrollLength}`,
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
                            item.classList.toggle("active", index === 0);
                        });
                        setKnobStepByIndex(0);
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
                        item.classList.toggle("active", index <= currentStopIndex);
                    });

                    setKnobStepByIndex(currentStopIndex);
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

        window.addEventListener("resize", () => {
            measure();
            if (scrollTriggerInstance) {
                scrollTriggerInstance.refresh();
            }
        });
    }
}
