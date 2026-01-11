import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import { initFeedbackForm } from "../components/initFeedbackForm";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const swiper = new Swiper(".swiper-content", {
        slidesPerView: 3,
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
    });
}

initFeedbackForm(".have-a-questions");
