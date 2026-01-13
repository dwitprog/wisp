import Swiper from "swiper";
import { Navigation } from "swiper/modules";
import { initFeedbackForm } from "../components/initFeedbackForm";

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

// Инициализация формы
initFeedbackForm(".have-a-questions");
