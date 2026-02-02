import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { initFeedbackForm } from "../components/initFeedbackForm";
import { initProjectStagesAnimation } from "../components/initProjectStagesAnimation";

gsap.registerPlugin(ScrollTrigger);

// swiper в секции platforms
const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const swiper = new Swiper(".swiper-content", {
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        speed: 1000,
        grabCursor: true,
        modules: [Navigation],
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
        },
    });
}

// Анимация координат на первом экране
const coordinateContainer = document.querySelector(".coordinates");

if (coordinateContainer) {
    const lineTop = coordinateContainer.querySelector(".line-top .line");
    const lineRight = coordinateContainer.querySelector(".line-right .line");

    // Функция для анимации линий
    function animateLines() {
        // Анимация верхней линии (высота)
        if (lineTop) {
            lineTop.style.display = "block";
            lineTop.style.height = "0";
            lineTop.style.transition = "none";
            setTimeout(() => {
                lineTop.style.transition = "height 1s ease-in-out";
                lineTop.style.height = "100%";
            }, 10);
        }

        // Анимация правой линии (ширина)
        if (lineRight) {
            lineRight.style.display = "block";
            lineRight.style.width = "0";
            lineRight.style.transition = "none";
            setTimeout(() => {
                lineRight.style.transition = "width 1s ease-in-out";
                lineRight.style.width = "100%";
            }, 10);
        }
    }

    // Запускаем анимацию при загрузке
    setTimeout(animateLines, 300);
}

// Анимация секции services (шаги по клику + drag)
const servicesSection = document.querySelector(".page-7.services");
if (servicesSection) {
    const knob = servicesSection.querySelector(".service-knob .knob");
    const list = servicesSection.querySelector(".list");
    const items = Array.from(servicesSection.querySelectorAll(".list .item"));
    const totalSteps = 5;
    const stepClasses = Array.from({ length: totalSteps }, (_, idx) => `step_${idx + 1}`);
    const maxItemIndex = Math.max(0, items.length - 1);
    const dragStepThreshold = 80;
    let currentStep = 1;
    let isDragging = false;
    let dragStartY = 0;
    let dragStartStep = 1;

    const setStep = stepNumber => {
        const normalizedStep = Math.min(totalSteps, Math.max(1, stepNumber));
        if (normalizedStep === currentStep) {
            return;
        }
        currentStep = normalizedStep;
        if (knob) {
            knob.classList.remove(...stepClasses);
            knob.classList.add(`step_${normalizedStep}`);
        }

        if (items.length) {
            const targetIndex = Math.min(normalizedStep - 1, maxItemIndex);
            items.forEach((item, index) => {
                item.classList.toggle("active", index === targetIndex);
            });
        }
    };

    const measureListHeight = () => {
        if (!list || !items.length) {
            return;
        }
        const activeIndex = items.findIndex(item => item.classList.contains("active"));
        servicesSection.classList.add("is-measuring");
        items.forEach(item => item.classList.remove("active"));
        let maxHeight = 0;

        items.forEach(item => {
            item.classList.add("active");
            const height = list.getBoundingClientRect().height;
            maxHeight = Math.max(maxHeight, height);
            item.classList.remove("active");
        });

        if (activeIndex >= 0) {
            items[activeIndex].classList.add("active");
        } else if (items[0]) {
            items[0].classList.add("active");
        }
        servicesSection.classList.remove("is-measuring");
        if (maxHeight) {
            list.style.minHeight = `${Math.ceil(maxHeight)}px`;
        }
    };

    setStep(1);
    setTimeout(measureListHeight, 0);

    items.forEach((item, index) => {
        item.addEventListener("click", event => {
            event.preventDefault();
            setStep(index + 1);
        });
    });

    if (knob) {
        knob.addEventListener("pointerdown", event => {
            event.preventDefault();
            isDragging = true;
            dragStartY = event.clientY;
            dragStartStep = currentStep;
            knob.classList.add("is-dragging");
            try {
                knob.setPointerCapture(event.pointerId);
            } catch (error) {
                // ignore capture errors in unsupported browsers
            }
        });

        const handlePointerMove = event => {
            if (!isDragging) {
                return;
            }
            const deltaY = event.clientY - dragStartY;
            const stepOffset = Math.trunc(deltaY / dragStepThreshold);
            setStep(dragStartStep + stepOffset);
        };

        const stopDragging = event => {
            if (!isDragging) {
                return;
            }
            isDragging = false;
            knob.classList.remove("is-dragging");
            try {
                knob.releasePointerCapture(event.pointerId);
            } catch (error) {
                // ignore release errors in unsupported browsers
            }
        };

        knob.addEventListener("pointermove", handlePointerMove);
        knob.addEventListener("pointerup", stopDragging);
        knob.addEventListener("pointercancel", stopDragging);
        knob.addEventListener("pointerleave", stopDragging);
    }

    window.addEventListener("resize", () => {
        setStep(currentStep);
        measureListHeight();
    });
    window.addEventListener("load", measureListHeight);
}

// Анимация секции project-stages (pin + движение круга)
const projectStagesSection = document.querySelector(".page-7.project-stages");
initProjectStagesAnimation({
    section: projectStagesSection,
});

// Анимация секции faq (клик + перетаскивание фейдера)
const faqSection = document.querySelector(".page-7.faq");
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

const haveAQuestionsForm = document.querySelector(".page-7.have-a-questions");
if (haveAQuestionsForm) {
    const formContent = haveAQuestionsForm.querySelector(".page-7.have-a-questions .content");
    const afterSendContent = haveAQuestionsForm.querySelector(".page-7.have-a-questions  .after-send");
    const btnSubmit = haveAQuestionsForm.querySelector(".page-7.have-a-questions .btn-send");
    initFeedbackForm(".have-a-questions", {
        validateFields: {
            name: { required: true, selector: 'input[name="name"]' },
            email: { required: true, email: true, selector: 'input[name="email"]' },
            price: {
                required: true,
                selector: ".select-services-price",
                customSelect: true,
                messages: {
                    required: "Please select at least one service",
                },
            },
            services: {
                required: true,
                selector: ".select-services",
                customSelect: true,
                messages: {
                    required: "Please select at least one service",
                },
            },
        },
        showSuccessMessage: false,
        callbacks: {
            beforeSubmit: () => {
                btnSubmit.setAttribute("disabled", "disabled");
            },
            onSubmit: formData => {
                const ajaxUrl = window.rgData?.ajax_url;
                const ajaxNonce = window.rgData?.ajax_nonce;

                if (!ajaxUrl || !ajaxNonce) {
                    return Promise.reject(new Error("Missing ajax config"));
                }

                const payload = new URLSearchParams();
                payload.append("action", "st_send_form");
                payload.append("nonce", ajaxNonce);
                payload.append("page_url", window.location.href);

                Object.entries(formData).forEach(([key, value]) => {
                    if (Array.isArray(value)) {
                        value.forEach(entry => payload.append(key, entry));
                    } else {
                        payload.append(key, value);
                    }
                });

                return fetch(ajaxUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    },
                    body: payload.toString(),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Request failed");
                        }
                        return response.json();
                    })
                    .then(result => {
                        if (!result?.success) {
                            throw new Error(result?.data?.message || "Mail error");
                        }
                        if (formContent) {
                            formContent.classList.add("send-ok");
                        }
                        if (afterSendContent) {
                            afterSendContent.classList.add("active");
                        }
                        return result;
                    });
            },
            onSuccess: () => {
                btnSubmit.removeAttribute("disabled", "disabled");
                if (formContent) {
                    gsap.to(formContent, {
                        autoAlpha: 0,
                        duration: 0.35,
                        ease: "power1.out",
                    });
                }

                if (afterSendContent) {
                    gsap.set(afterSendContent, { display: "flex" });
                    gsap.fromTo(
                        afterSendContent,
                        { autoAlpha: 0 },
                        {
                            autoAlpha: 1,
                            duration: 0.4,
                            ease: "power1.out",
                        },
                    );
                }
            },
        },
    });
}
