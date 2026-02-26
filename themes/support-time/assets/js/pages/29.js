// swiper
import Swiper from "swiper";
import { Navigation, Pagination, Autoplay } from "swiper/modules";

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

        // На больших шрифтах (.highglass) — слайдер по центру: 1 центральный полностью, два по бокам наполовину
        const isHighglass = document.body.classList.contains("highglass");
        const swiperOptions = {
            spaceBetween: 20,
            grabCursor: true,
            modules: [Navigation, Pagination, Autoplay],
            loop: true,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".swiper-next",
                prevEl: ".swiper-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                type: "bullets",
                clickable: true,
            },
        };
        if (isHighglass) {
            swiperOptions.centeredSlides = true;
            swiperOptions.slidesPerView = 2;
            swiperOptions.initialSlide = 1;
            swiperOptions.loop = false;
        } else {
            swiperOptions.slidesPerView = 3.4;
        }
        const container = servicesSection.querySelector(".swiper-container");
        if (container) {
            container.style.opacity = "0";
            container.style.transition = "opacity 0.4s ease";
        }
        swiperInstance = new Swiper(".swiper-container", {
            ...swiperOptions,
            on: {
                ...swiperOptions.on,
                init(swiper) {
                    if (swiperOptions.on?.init) swiperOptions.on.init(swiper);
                    requestAnimationFrame(() => {
                        if (container) container.style.opacity = "1";
                    });
                },
            },
        });
    }

    // Инициализация при загрузке страницы
    initSwiper();

    // При смене режима шрифта (большие шрифты) переинициализируем слайдер с другими параметрами
    window.addEventListener("highglasschange", function () {
        if (swiperInstance) {
            swiperInstance.destroy(true, true);
            swiperInstance = null;
        }
        if (isDesktopResolution()) {
            initSwiper();
        }
    });

    // Обработчик изменения размера окна с debounce
    let resizeTimeout;
    window.addEventListener("resize", function () {
        initSwiper();
    });
}
