// swiper в секции platforms
import Swiper from "swiper";
import { Navigation, Pagination, Thumbs } from "swiper/modules";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const thumbsEl = platformsSection.querySelector(".platforms-swiper-thumbs");
    const mainEl = platformsSection.querySelector(".platforms-swiper-main");
    if (thumbsEl) {
        thumbsEl.style.opacity = "0";
        thumbsEl.style.transition = "opacity 0.4s ease";
    }
    if (mainEl) {
        mainEl.style.opacity = "0";
        mainEl.style.transition = "opacity 0.4s ease";
    }
    // Миниатюры
    const thumbsSwiper = new Swiper(".platforms-swiper-thumbs", {
        slidesPerView: 1,
        spaceBetween: 24,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
        breakpoints: {
            768: {
                slidesPerView: 2.5,
                spaceBetween: 32,
            },
            992: {
                slidesPerView: 2.5,
                spaceBetween: 24,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 60,
            },
            1400: {
                slidesPerView: 4,
                spaceBetween: 60,
            },
        },
        on: {
            init() {
                requestAnimationFrame(() => {
                    if (thumbsEl) thumbsEl.style.opacity = "1";
                });
            },
        },
    });

    // Основной
    const mainSwiper = new Swiper(".platforms-swiper-main", {
        slidesPerView: 1,
        spaceBetween: 60,
        grabCursor: true,
        modules: [Thumbs, Navigation, Pagination],
        thumbs: {
            swiper: thumbsSwiper,
        },
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        on: {
            init() {
                requestAnimationFrame(() => {
                    if (mainEl) mainEl.style.opacity = "1";
                });
            },
        },
    });

    const getPlatformParam = () => {
        const params = new URLSearchParams(window.location.search);
        if (!params.has("platform")) {
            return null;
        }
        const value = params.get("platform");
        if (!value) {
            return null;
        }
        try {
            return decodeURIComponent(value);
        } catch (error) {
            return value;
        }
    };

    const normalizeValue = value => (value || "").trim().replace(/\/$/, "").toLowerCase();
    const platformParam = getPlatformParam();

    if (platformParam) {
        const normalizedParam = normalizeValue(platformParam);
        const slides = Array.from(mainSwiper.slides);
        const targetIndex = slides.findIndex(slide => {
            const platformValue = normalizeValue(slide.dataset.platform);
            return platformValue === normalizedParam;
        });

        if (targetIndex >= 0) {
            mainSwiper.slideTo(targetIndex, 0);
            thumbsSwiper.slideTo(targetIndex, 0);
        }
    }
}
