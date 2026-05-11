import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";

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
    const knob = howWeWorkSection.querySelector(".service-knob .knob");
    const stepClasses = ["step_2", "step_3", "step_4"];

    const syncKnob = index => {
        if (!knob) return;
        const stepNumber = Math.min(4, Math.max(2, index + 2));
        knob.classList.remove(...stepClasses);
        knob.classList.add(`step_${stepNumber}`);
    };

    initProjectStagesAnimation({
        section: howWeWorkSection,
        onActiveStepChange: activeIndex => {
            if (activeIndex < 0) {
                if (knob) {
                    knob.classList.remove(...stepClasses);
                    knob.classList.add("step_2");
                }
                return;
            }
            syncKnob(activeIndex);
        },
    });
}
