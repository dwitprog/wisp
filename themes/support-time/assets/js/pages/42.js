// swiper в секции platforms
import Swiper from "swiper";
import { Navigation, Pagination, Thumbs } from "swiper/modules";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    // Миниатюры
    const thumbsSwiper = new Swiper(".platforms-swiper-thumbs", {
        slidesPerView: 1,
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
}
