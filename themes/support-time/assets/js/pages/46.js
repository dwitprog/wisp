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
        const totalSteps = 5;
        const stepClasses = Array.from({ length: totalSteps }, (_, idx) => `step_${idx + 1}`);
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        const scrollLengthMultiplier = 4;

        let lineOffset = 0;
        let circleHeight = 0;
        let maxTravel = 0;
        let itemThresholds = [];
        let stopPoints = [];

        const setKnobStep = stepNumber => {
            knob.classList.remove(...stepClasses);
            knob.classList.add(`step_${stepNumber}`);
        };

        const measure = () => {
            const sectionTop = howWeWorkSection.getBoundingClientRect().top + window.scrollY;

            circleHeight = circle.offsetHeight;
            lineOffset = line.getBoundingClientRect().top + window.scrollY - sectionTop;
            maxTravel = Math.max(0, line.offsetHeight - circleHeight);
            itemThresholds = items.map(item => item.getBoundingClientRect().top + window.scrollY - sectionTop + 6);
            stopPoints = [
                0,
                ...itemThresholds.map(threshold => clamp(threshold - lineOffset, 0, maxTravel)),
                maxTravel,
            ];
        };

        measure();
        gsap.set(circle, { y: 0 });
        setKnobStep(1);

        ScrollTrigger.create({
            trigger: howWeWorkSection,
            start: "top top",
            end: () => `+=${Math.max(1, maxTravel) * scrollLengthMultiplier}`,
            pin: true,
            pinSpacing: true,
            scrub: true,
            onRefresh: measure,
            onUpdate: self => {
                const rawTravel = clamp(self.progress * maxTravel, 0, maxTravel);
                let snappedTravel = stopPoints[0] ?? 0;
                let snappedIndex = 0;

                for (let i = 1; i < stopPoints.length; i += 1) {
                    if (Math.abs(stopPoints[i] - rawTravel) < Math.abs(snappedTravel - rawTravel)) {
                        snappedTravel = stopPoints[i];
                        snappedIndex = i;
                    }
                }

                const travel = clamp(snappedTravel, 0, maxTravel);
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

                setKnobStep(clamp(snappedIndex + 1, 1, totalSteps));
            },
        });
    }
}
