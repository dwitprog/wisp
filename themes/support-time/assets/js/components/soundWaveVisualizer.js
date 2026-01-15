/**
 * SoundWaveVisualizer - Визуализатор звуковой волны
 * Создает анимированную звуковую дорожку, которая может быть интегрирована с аудиоплеером
 *
 * @param {Object} options - Настройки визуализатора
 * @param {string} options.svgId - ID SVG элемента
 * @param {string} options.playBtnSelector - Селектор кнопки play/pause
 * @param {Object} options.animation - Настройки анимации
 * @param {number} options.animation.minMultiplier - Минимальный множитель высоты (по умолчанию 0.8)
 * @param {number} options.animation.maxMultiplier - Максимальный множитель высоты (по умолчанию 1.5)
 * @param {number} options.animation.speed - Скорость анимации (по умолчанию 0.2)
 * @param {number} options.animation.fps - Кадров в секунду (по умолчанию 30)
 * @returns {Object} API для управления визуализатором
 */
export function soundWaveVisualizer(options = {}) {
    // Конфигурация по умолчанию
    const config = {
        svgId: "soundWave",
        playBtnSelector: ".controls-btn.play",
        animation: {
            minMultiplier: 0.8,
            maxMultiplier: 1.5,
            speed: 0.2,
            fps: 30,
        },
        ...options,
    };

    // Состояние визуализатора
    const state = {
        isAnimating: false,
        animationId: null,
        lastFrameTime: 0,
        lines: [],
        originalCoords: [],
        currentValues: [],
    };

    // DOM элементы
    let elements = {
        svg: null,
        playBtn: null,
        pauseSvg: null,
        startSvg: null,
        wrapper: null,
    };

    /**
     * Инициализация визуализатора
     */
    function init() {
        // Находим DOM элементы
        elements.svg = document.getElementById(config.svgId);
        elements.playBtn = document.querySelector(config.playBtnSelector);

        if (!elements.svg || !elements.playBtn) {
            console.error("SoundWaveVisualizer: Не найдены необходимые элементы");
            return null;
        }

        elements.pauseSvg = elements.playBtn.querySelector(".pause");
        elements.startSvg = elements.playBtn.querySelector(".start");
        elements.wrapper = elements.svg.closest(".sound-wrapper");

        // Получаем все линии
        state.lines = Array.from(elements.svg.querySelectorAll("line"));

        // Сохраняем оригинальные координаты
        state.originalCoords = state.lines.map(line => {
            const y1 = parseFloat(line.getAttribute("y1"));
            const y2 = parseFloat(line.getAttribute("y2"));
            const centerY = (y1 + y2) / 2;
            const height = Math.abs(y2 - y1);
            return { y1, y2, centerY, height };
        });

        // Инициализируем текущие значения
        state.currentValues = state.lines.map(() => ({
            multiplier: 1,
            targetMultiplier: 1,
        }));

        // Убираем CSS transition для мгновенной реакции
        state.lines.forEach(line => {
            line.style.transition = "none";
        });

        // Настройка начального состояния
        if (elements.pauseSvg) elements.pauseSvg.style.display = "none";
        if (elements.startSvg) elements.startSvg.style.display = "block";

        // Добавляем обработчики событий
        setupEventListeners();

        // Добавляем стили
        addStyles();

        console.log("SoundWaveVisualizer: Инициализирован");

        return api;
    }

    /**
     * Настройка обработчиков событий
     */
    function setupEventListeners() {
        // Обработчик клика на кнопку play/pause
        elements.playBtn.addEventListener("click", handlePlayPauseClick);

        // Обработчики для кнопок prev/next (можно расширить позже)
        const prevBtn = document.querySelector(".controls-btn.prev");
        const nextBtn = document.querySelector(".controls-btn.next");

        if (prevBtn) {
            prevBtn.addEventListener("click", () => api.emit("prev"));
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => api.emit("next"));
        }
    }

    /**
     * Добавление CSS стилей
     */
    function addStyles() {
        const styleId = "sound-wave-visualizer-styles";

        // Удаляем старые стили, если они есть
        const existingStyle = document.getElementById(styleId);
        if (existingStyle) existingStyle.remove();

        const style = document.createElement("style");
        style.id = styleId;
        style.textContent = `
            .sound-wave line {
                will-change: y1, y2;
            }
            
            .sound-wrapper.playing .sound-wave {
                filter: drop-shadow(0 0 8px rgba(162, 89, 132, 0.4));
                transition: filter 0.3s ease;
            }
            
            .sound-wrapper.playing .controls-btn.play {
                background: rgba(162, 89, 132, 0.3);
            }
            
            .controls-btn {
                cursor: pointer;
                transition: all 0.3s ease;
            }
            
            .controls-btn:hover {
                transform: scale(1.05);
            }
            
            .controls-btn.play:hover {
                background: rgba(162, 89, 132, 0.25);
            }
            
            .pause line {
                stroke: #A25984 !important;
            }
            
            .sound-wrapper.playing .pause line {
                stroke: white !important;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Обработчик клика на кнопку play/pause
     */
    function handlePlayPauseClick() {
        if (state.isAnimating) {
            api.stop();
        } else {
            api.start();
        }
    }

    /**
     * Основной цикл анимации
     */
    function animate(timestamp) {
        if (!state.lastFrameTime) state.lastFrameTime = timestamp;

        const frameDuration = 1000 / config.animation.fps;
        const elapsed = timestamp - state.lastFrameTime;

        if (elapsed > frameDuration) {
            state.lastFrameTime = timestamp;
            updateWave();
        }

        if (state.isAnimating) {
            state.animationId = requestAnimationFrame(animate);
        }
    }

    /**
     * Обновление волны
     */
    function updateWave() {
        state.lines.forEach((line, index) => {
            const original = state.originalCoords[index];
            const current = state.currentValues[index];

            if (state.isAnimating) {
                // Плавное приближение к целевому множителю
                const diff = current.targetMultiplier - current.multiplier;
                if (Math.abs(diff) > 0.01) {
                    current.multiplier += diff * config.animation.speed;
                } else {
                    // Генерируем новый целевой множитель
                    const range = config.animation.maxMultiplier - config.animation.minMultiplier;
                    current.targetMultiplier = config.animation.minMultiplier + Math.random() * range;
                }
            }

            // Рассчитываем новую высоту и координаты
            const newHeight = original.height * current.multiplier;
            const newY1 = original.centerY - newHeight / 2;
            const newY2 = original.centerY + newHeight / 2;

            // Обновляем линию
            line.setAttribute("y1", newY1);
            line.setAttribute("y2", newY2);
        });
    }

    /**
     * Обновление визуализации на основе аудиоданных
     * @param {Array<number>|Float32Array} frequencyData - Данные частот из анализатора
     */
    function updateFromAudioData(frequencyData) {
        if (!frequencyData || !frequencyData.length) return;

        const dataPoints = Math.min(frequencyData.length, state.lines.length);
        const step = Math.floor(frequencyData.length / dataPoints);

        state.lines.forEach((line, index) => {
            if (index < dataPoints) {
                const original = state.originalCoords[index];
                const dataIndex = Math.min(index * step, frequencyData.length - 1);

                // Нормализуем значение (0-255) в множитель (0.5-2.0)
                const normalizedValue = frequencyData[dataIndex] / 255;
                const multiplier = 0.5 + normalizedValue * 1.5;

                // Рассчитываем новую высоту
                const newHeight = original.height * multiplier;
                const newY1 = original.centerY - newHeight / 2;
                const newY2 = original.centerY + newHeight / 2;

                // Обновляем линию
                line.setAttribute("y1", newY1);
                line.setAttribute("y2", newY2);
            }
        });
    }

    /**
     * Обработчики событий
     */
    const eventHandlers = {
        play: [],
        pause: [],
        prev: [],
        next: [],
    };

    /**
     * Публичное API
     */
    const api = {
        /**
         * Запуск анимации
         */
        start() {
            if (state.isAnimating) return;

            state.isAnimating = true;
            state.lastFrameTime = 0;

            if (elements.pauseSvg) {
                elements.pauseSvg.style.display = "block";
                elements.startSvg.style.display = "none";
            }

            if (elements.wrapper) {
                elements.wrapper.classList.add("playing");
            }

            state.animationId = requestAnimationFrame(animate);
            api.emit("play");

            console.log("SoundWaveVisualizer: Анимация запущена");
        },

        /**
         * Остановка анимации
         */
        stop() {
            if (!state.isAnimating) return;

            state.isAnimating = false;

            if (state.animationId) {
                cancelAnimationFrame(state.animationId);
                state.animationId = null;
            }

            if (elements.pauseSvg) {
                elements.pauseSvg.style.display = "none";
                elements.startSvg.style.display = "block";
            }

            if (elements.wrapper) {
                elements.wrapper.classList.remove("playing");
            }

            api.emit("pause");
            console.log("SoundWaveVisualizer: Анимация остановлена");
        },

        /**
         * Перезапуск анимации
         */
        restart() {
            api.stop();
            setTimeout(() => api.start(), 100);
        },

        /**
         * Обновление конфигурации
         * @param {Object} newConfig - Новая конфигурация
         */
        updateConfig(newConfig) {
            Object.assign(config, newConfig);
            console.log("SoundWaveVisualizer: Конфигурация обновлена", config);
        },

        /**
         * Получение текущего состояния
         */
        getState() {
            return {
                isPlaying: state.isAnimating,
                config: { ...config },
            };
        },

        /**
         * Подписка на события
         * @param {string} event - Событие (play, pause, prev, next)
         * @param {Function} handler - Обработчик
         */
        on(event, handler) {
            if (eventHandlers[event]) {
                eventHandlers[event].push(handler);
            }
        },

        /**
         * Отписка от события
         * @param {string} event - Событие
         * @param {Function} handler - Обработчик
         */
        off(event, handler) {
            if (eventHandlers[event]) {
                const index = eventHandlers[event].indexOf(handler);
                if (index > -1) {
                    eventHandlers[event].splice(index, 1);
                }
            }
        },

        /**
         * Генерация события
         * @param {string} event - Событие
         * @param {*} data - Данные
         */
        emit(event, data = null) {
            if (eventHandlers[event]) {
                eventHandlers[event].forEach(handler => {
                    try {
                        handler(data);
                    } catch (error) {
                        console.error(`SoundWaveVisualizer: Ошибка в обработчике события ${event}`, error);
                    }
                });
            }
        },

        /**
         * Обновление визуализации на основе аудиоданных
         * @param {Array<number>|Float32Array} frequencyData - Данные частот
         */
        updateFromAudioData,

        /**
         * Уничтожение визуализатора и очистка ресурсов
         */
        destroy() {
            api.stop();

            // Удаляем обработчики
            elements.playBtn.removeEventListener("click", handlePlayPauseClick);

            // Удаляем стили
            const style = document.getElementById("sound-wave-visualizer-styles");
            if (style) style.remove();

            // Очищаем массивы
            state.lines = [];
            state.originalCoords = [];
            state.currentValues = [];

            // Очищаем обработчики событий
            Object.keys(eventHandlers).forEach(key => {
                eventHandlers[key] = [];
            });

            console.log("SoundWaveVisualizer: Уничтожен");
        },
    };

    // Инициализация и возврат API
    return init();
}
