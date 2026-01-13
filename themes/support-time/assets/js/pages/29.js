// swiper
import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";

const servicesSection = document.querySelector(".page-29.services");

if (servicesSection) {
    // Функция для проверки разрешения экрана
    function isDesktopResolution() {
        return window.innerWidth >= 1200;
    }

    // Переменная для хранения экземпляра Swiper
    let swiperInstance = null;

    // Функция инициализации Swiper
    function initSwiper() {
        // Проверяем разрешение
        if (!isDesktopResolution()) {
            // Если Swiper был инициализирован ранее, уничтожаем его
            if (swiperInstance) {
                swiperInstance.destroy(true, true);
                swiperInstance = null;
            }
            return;
        }

        // Если Swiper уже инициализирован, не инициализируем повторно
        if (swiperInstance) {
            return;
        }

        // Инициализируем Swiper только на десктопе
        swiperInstance = new Swiper(".swiper-container", {
            slidesPerView: 3.4,
            spaceBetween: 20,
            grabCursor: true,
            modules: [Navigation, Pagination],
            navigation: {
                nextEl: ".swiper-next",
                prevEl: ".swiper-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                type: "bullets",
                clickable: true,
            },
        });
    }

    // Инициализация при загрузке страницы
    initSwiper();

    // Обработчик изменения размера окна с debounce
    let resizeTimeout;
    window.addEventListener("resize", function () {
        initSwiper();
    });
}
