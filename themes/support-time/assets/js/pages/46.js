import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const howWeWorkSection = document.querySelector(".page-46.how-we-work");

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
            end: () => `+=${Math.max(1, maxTravel)}`,
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
