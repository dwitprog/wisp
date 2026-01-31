// swiper в секции platforms
import Swiper from "swiper";
import { Navigation, Pagination, Thumbs } from "swiper/modules";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    // Миниатюры
    const thumbsSwiper = new Swiper(".platforms-swiper-thumbs", {
        slidesPerView: 1.5,
        spaceBetween: 24,
        watchSlidesProgress: true,
        slideToClickedSlide: true,
        breakpoints: {
            576: {
                slidesPerView: 1.5,
                spaceBetween: 24,
            },
            768: {
                slidesPerView: 2.5,
                spaceBetween: 32,
            },
            992: {
                spaceBetween: 24,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 60,
            },
        },
    });

    // Основной
    const mainSwiper = new Swiper(".platforms-swiper-main", {
        slidesPerView: 1,
        spaceBetween: 60,

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
