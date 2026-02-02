import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
// Анимация секции faq (клик + перетаскивание фейдера)
const faqSection = document.querySelector(".page-44.faq");
if (faqSection) {
    const faqContent = faqSection.querySelector(".faq-content");
    const slider = faqSection.querySelector(".slider");
    const sliderLine = faqSection.querySelector(".slider-line");
    const sliderFader = faqSection.querySelector(".slider-fader");
    const itemsContainer = faqSection.querySelector(".items");
    const items = Array.from(faqSection.querySelectorAll(".items .item"));

    if (faqContent && slider && sliderLine && sliderFader && itemsContainer && items.length) {
        let sliderHeight = 0;
        let faderHeight = 0;
        let maxTravel = 0;
        let sliderOffset = 0;
        let itemThresholds = [];
        let contentPaddingTop = 0;
        const itemMarkerOffset = 15;
        const faderSwitchOffset = 5;
        const clamp = (value, min, max) => Math.min(max, Math.max(min, value));
        let currentTravel = 0;
        let lastTravel = 0;
        let activeIndex = Math.max(
            0,
            items.findIndex(item => item.classList.contains("active")),
        );
        let dragActive = false;
        let dragFrame = null;
        let moveTween = null;
        let remeasureFrame = null;
        let clickDelayTimeout = null;
        let dragOffsetY = 0;

        const getItemMarkerTop = (item, contentTop) => {
            const markerTarget = item.querySelector("input, .title") || item;
            const markerTop = markerTarget.getBoundingClientRect().top + window.scrollY - contentTop;
            return markerTarget === item ? markerTop + itemMarkerOffset : markerTop;
        };

        const measure = () => {
            const contentTop = faqContent.getBoundingClientRect().top + window.scrollY;
            contentPaddingTop = parseFloat(getComputedStyle(faqContent).paddingTop) || 0;
            sliderHeight = Math.max(itemsContainer.offsetHeight, slider.offsetHeight);
            if (sliderHeight > 0) {
                slider.style.height = `${sliderHeight}px`;
            }
            faderHeight = sliderFader.offsetHeight;
            maxTravel = Math.max(0, sliderHeight - faderHeight);
            sliderOffset = slider.getBoundingClientRect().top + window.scrollY - contentTop;
            itemThresholds = items.map(item => {
                const markerTop = getItemMarkerTop(item, contentTop);
                const itemBottom = item.getBoundingClientRect().bottom + window.scrollY - contentTop;
                return {
                    start: markerTop,
                    end: itemBottom,
                };
            });
        };

        const getFaderTop = () => sliderOffset + currentTravel;
        const getFaderBottom = () => getFaderTop() + faderHeight;

        const getTravelForIndex = index => clamp(itemThresholds[index].start - sliderOffset, 0, maxTravel);

        const scheduleRemeasure = () => {
            if (remeasureFrame) {
                cancelAnimationFrame(remeasureFrame);
            }
            remeasureFrame = requestAnimationFrame(() => {
                measure();
                remeasureFrame = null;
            });
        };

        const setActiveIndex = nextIndex => {
            if (nextIndex === activeIndex) return;
            activeIndex = nextIndex;
            items.forEach((item, index) => {
                item.classList.toggle("active", index === activeIndex);
            });
            scheduleRemeasure();
        };

        const setActiveByFader = previousTravel => {
            const faderTop = getFaderTop();
            const faderBottom = getFaderBottom();
            const lastPosition = typeof previousTravel === "number" ? previousTravel : lastTravel;
            const isMovingDown = currentTravel >= lastPosition;
            let nextIndex = activeIndex;

            if (isMovingDown) {
                for (let i = 0; i < itemThresholds.length; i += 1) {
                    const start = itemThresholds[i].start + faderSwitchOffset;
                    if (faderBottom >= start) {
                        nextIndex = i;
                    } else {
                        break;
                    }
                }
            } else {
                for (let i = 0; i < itemThresholds.length; i += 1) {
                    const end = itemThresholds[i].end - faderSwitchOffset;
                    if (faderTop <= end) {
                        nextIndex = i;
                        break;
                    }
                }
            }

            setActiveIndex(nextIndex);
            lastTravel = currentTravel;
        };

        const setFaderPosition = (value, animate = false, syncActive = true) => {
            const nextTravel = clamp(value, 0, maxTravel);
            if (moveTween) {
                moveTween.kill();
                moveTween = null;
            }

            if (animate) {
                const state = { value: currentTravel };
                moveTween = gsap.to(state, {
                    value: nextTravel,
                    duration: 0.35,
                    ease: "power1.out",
                    onUpdate: () => {
                        const previousTravel = currentTravel;
                        currentTravel = state.value;
                        gsap.set(sliderFader, { y: currentTravel });
                        if (syncActive) {
                            setActiveByFader(previousTravel);
                        } else {
                            lastTravel = currentTravel;
                        }
                    },
                    onComplete: () => {
                        const previousTravel = currentTravel;
                        currentTravel = nextTravel;
                        gsap.set(sliderFader, { y: currentTravel });
                        if (syncActive) {
                            setActiveByFader(previousTravel);
                        } else {
                            lastTravel = currentTravel;
                        }
                        moveTween = null;
                    },
                });
            } else {
                const previousTravel = currentTravel;
                currentTravel = nextTravel;
                gsap.set(sliderFader, { y: currentTravel });
                if (syncActive) {
                    setActiveByFader(previousTravel);
                } else {
                    lastTravel = currentTravel;
                }
            }
        };

        const touchListenerOptions = { passive: false };
        const getClientY = event => {
            if (event?.touches?.length) {
                return event.touches[0].clientY;
            }
            if (event?.changedTouches?.length) {
                return event.changedTouches[0].clientY;
            }
            return event?.clientY;
        };

        const getTravelFromPointer = clientY => {
            const lineRect = sliderLine.getBoundingClientRect();
            return clientY - lineRect.top - dragOffsetY;
        };

        const startDragging = event => {
            if (event?.cancelable) {
                event.preventDefault();
            }
            measure();
            dragActive = true;
            const faderRect = sliderFader.getBoundingClientRect();
            const clientY = getClientY(event);
            if (typeof clientY !== "number") {
                return;
            }
            dragOffsetY = clamp(clientY - faderRect.top, 0, faderRect.height);
            if (dragFrame) {
                cancelAnimationFrame(dragFrame);
            }
            setFaderPosition(getTravelFromPointer(clientY));
            window.addEventListener("pointermove", handleDragging);
            window.addEventListener("pointerup", stopDragging);
            window.addEventListener("pointercancel", stopDragging);
            window.addEventListener("touchmove", handleDragging, touchListenerOptions);
            window.addEventListener("touchend", stopDragging);
            window.addEventListener("touchcancel", stopDragging);
        };

        const handleDragging = event => {
            if (!dragActive) return;
            if (event?.cancelable) {
                event.preventDefault();
            }
            if (dragFrame) {
                cancelAnimationFrame(dragFrame);
            }
            dragFrame = requestAnimationFrame(() => {
                const clientY = getClientY(event);
                if (typeof clientY !== "number") {
                    return;
                }
                setFaderPosition(getTravelFromPointer(clientY));
            });
        };

        const stopDragging = () => {
            dragActive = false;
            if (dragFrame) {
                cancelAnimationFrame(dragFrame);
                dragFrame = null;
            }
            window.removeEventListener("pointermove", handleDragging);
            window.removeEventListener("pointerup", stopDragging);
            window.removeEventListener("pointercancel", stopDragging);
            window.removeEventListener("touchmove", handleDragging, touchListenerOptions);
            window.removeEventListener("touchend", stopDragging);
            window.removeEventListener("touchcancel", stopDragging);
        };

        measure();
        setFaderPosition(getTravelForIndex(activeIndex));

        sliderFader.addEventListener("pointerdown", startDragging);
        sliderLine.addEventListener("pointerdown", startDragging);
        sliderFader.addEventListener("touchstart", startDragging, touchListenerOptions);
        sliderLine.addEventListener("touchstart", startDragging, touchListenerOptions);

        items.forEach((item, index) => {
            item.addEventListener("click", event => {
                event.preventDefault();
                setActiveIndex(index);
                if (clickDelayTimeout) {
                    clearTimeout(clickDelayTimeout);
                }
                clickDelayTimeout = setTimeout(() => {
                    measure();
                    const targetTravel = getTravelForIndex(index);
                    setFaderPosition(targetTravel, maxTravel > 0, false);
                }, 400);
            });
        });

        window.addEventListener("resize", () => {
            measure();
            setFaderPosition(getTravelForIndex(activeIndex));
        });
    }
}
