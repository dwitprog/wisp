import Swiper from "swiper";

const platformsSection = document.querySelector(".platforms");
if (platformsSection) {
    const swiper = new Swiper(".swiper-content", {
        slidesPerView: 1,
        spaceBetween: 10,
    });
}
