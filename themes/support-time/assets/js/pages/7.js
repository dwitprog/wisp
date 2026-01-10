import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const swiper = new Swiper(".swiper-content", {
        slidesPerView: 3,
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        speed: 1000,
        grabCursor: true,
        modules: [Navigation, Pagination],
        navigation: {
            nextEl: ".swiper-next",
            prevEl: ".swiper-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            type: "bullets",
        },
    });
}
